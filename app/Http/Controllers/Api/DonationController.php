<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Status;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    /**
     * Tampilkan daftar campaign aktif
     */
    public function index()
    {
        $campaigns = Campaign::with(['category'])->where('status', 'active')->get();

        return response()->json([
            'status' => 'success',
            'data' => $campaigns
        ], 200);
    }

    /**
     * Detail campaign
     */
    public function show($id)
    {
        try {
            $campaign = Campaign::with(['category'])->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $campaign->id,
                    'title' => $campaign->title,
                    'slug' => $campaign->slug,
                    'image' => $campaign->image ? Storage::url($campaign->image) : null,
                    'goal_amount' => $campaign->goal_amount,
                    'goal_amount_formatted' => number_format($campaign->goal_amount, 0, ',', '.'),
                    'total_collected' => $campaign->total_collected,
                    'total_collected_formatted' => number_format($campaign->total_collected, 0, ',', '.'),
                    'description' => $campaign->description,
                    'expired' => $campaign->expired,
                    'category_id' => $campaign->category_id,
                    'bank_info' => $campaign->bank_info,
                    'created_at' => $campaign->created_at,
                    'updated_at' => $campaign->updated_at,
                    'status' => $campaign->status,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kampanye tidak ditemukan: ' . $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Simpan donasi baru
     */
    public function store(Request $request)
    {
        try {
            // Bersihkan format rupiah jadi integer
            $request->merge([
                'amount' => preg_replace('/[^0-9]/', '', $request->amount)
            ]);

            $rules = [
                'campaign_id' => 'required|exists:campaigns,id',
                'amount' => 'required|numeric|min:10000',
                'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];

            if (!Auth::check()) {
                $rules['name'] = 'required|string|max:255';
                $rules['phone_number'] = 'required|string|max:20';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Pastikan campaign aktif & belum expired
            $campaign = Campaign::where('id', $request->campaign_id)
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('expired')
                      ->orWhere('expired', '>=', now());
                })
                ->first();

            if (!$campaign) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Campaign tidak aktif atau sudah berakhir.'
                ], 400);
            }

            // Data donasi
            $data = $request->except(['proof_image']);
            $data['user_id'] = Auth::id();
            $data['status_id'] = Status::where('name', 'pending')->first()->id;

            // Upload bukti transfer
            if ($request->hasFile('proof_image')) {
                $data['proof_image'] = $request->file('proof_image')->store('donations/proofs', 'public');
            }

            $donation = Donation::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Donasi berhasil dikirim, menunggu verifikasi admin.',
                'data' => $donation,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim donasi: ' . $e->getMessage(),
            ], 500);
        }
    }
}
