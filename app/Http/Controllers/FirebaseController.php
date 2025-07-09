<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Contract\Messaging;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FirebaseController extends Controller
{
    protected $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

   public function sendToTopic(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|in:news,events',
            'title' => 'required|string|max:100',
            'body' => 'required|string|max:200',
            'route' => 'required|string',
        ]);

        $message = CloudMessage::withTarget('topic', $request->topic)
            ->withNotification([
                'title' => $request->title,
                'body' => $request->body,
            ])
            ->withData(['route' => $request->route]);

        try {
            $this->messaging->send($message);
            Log::info('Notification sent to topic: ' . $request->topic);
            return response()->json(['message' => 'Notifikasi terkirim ke topik']);
        } catch (\Exception $e) {
            Log::error('FCM error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengirim notifikasi'], 500);
        }
    }

    public function checkNewNews()
    {
        try {
            $response = Http::timeout(10)->get('http://127.0.0.1:8000/api/post');
            if (!$response->successful()) {
                Log::error('Failed to fetch news API: ' . $response->status());
                return;
            }
            $data = $response->json()['data'] ?? [];
            if (empty($data)) {
                Log::warning('No news data found');
                return;
            }
            $latestNews = $data[0] ?? null;
            if (!$latestNews) {
                Log::warning('No latest news found');
                return;
            }

            $lastNewsId = Cache::get('last_news_id');
            if ($latestNews['id'] !== $lastNewsId) {
                $message = CloudMessage::withTarget('topic', 'news')
                    ->withNotification([
                        'title' => 'Berita Baru!',
                        'body' => $latestNews['title'],
                    ])
                    ->withData(['route' => '/post']);
                $this->messaging->send($message);
                Log::info('Sent news notification: ' . $latestNews['title']);
                Cache::put('last_news_id', $latestNews['id'], now()->addDays(7));
            }
        } catch (\Exception $e) {
            Log::error('Error checking news: ' . $e->getMessage());
        }
    }

    public function scheduleEventNotifications()
{
    try {
        $allEvents = [];
        $page = 1;
        do {
            $response = Http::timeout(60)->get('http://127.0.0.1:8000/api/event?page=' . $page);
            if (!$response->successful()) {
                Log::error('Failed to fetch agenda API: ' . $response->status());
                return;
            }
            $json = $response->json();
            Log::debug('API Event Response Page ' . $page . ': ' . json_encode($json));
            $events = $json['data'] ?? [];
            $allEvents = array_merge($allEvents, $events);
            $page++;
        } while (isset($json['links']['next']) && $json['links']['next']);

        if (empty($allEvents)) {
            Log::warning('No valid event data found');
            return;
        }

        foreach ($allEvents as $event) {
            if (!is_array($event) || !isset($event['date']) || !isset($event['id']) || !isset($event['title'])) {
                Log::warning('Invalid event data: ' . json_encode($event));
                continue;
            }
            $eventDate = new \DateTime($event['date'] . ' 00:00:00');
            $notifyTime = clone $eventDate;
            $notifyTime->modify('-1 hour');
            $cacheKey = 'event_notified_' . $event['id'];
            if ($notifyTime > now() && $notifyTime <= now()->addHours(24) && !Cache::has($cacheKey)) {
                $message = CloudMessage::withTarget('topic', 'events')
                    ->withNotification([
                        'title' => 'Pengingat Agenda',
                        'body' => "Jangan lupa: {$event['title']} pada {$eventDate->format('Y-m-d')}",
                    ])
                    ->withData(['route' => '/event/EventListScreen']);
                $this->messaging->send($message);
                Log::info('Sent event notification: ' . $event['title']);
                Cache::put($cacheKey, true, $eventDate);
            }
        }
    } catch (\Exception $e) {
        Log::error('Error scheduling events: ' . $e->getMessage());
    }
}
}