<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Status;
use App\Models\CategoriesCampaign;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    /**
     * Tampilkan daftar campaign aktif
     */
    public function index(Request $request)
    {
        try {
            // Inisialisasi query
            $query = Campaign::with('category')
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('expired')
                        ->orWhere('expired', '>=', now());
                });

            // Filter berdasarkan kategori jika ada
            if ($request->has('category')) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('name', $request->category);
                });
            }

            // Pagination
            $perPage = $request->input('per_page', 6); // Default 6 per halaman
            $campaigns = $query->latest()->paginate($perPage);

            // Map data menggunakan items() untuk mendapatkan collection
            $data = collect($campaigns->items())->map(function ($campaign) {
                return [
                    'id' => $campaign->id,
                    'title' => $campaign->title,
                    'slug' => $campaign->slug,
                    'image' => $campaign->image ? Storage::url($campaign->image) : null,
                    'goal_amount' => $campaign->goal_amount,
                    'goal_amount_formatted' => number_format($campaign->goal_amount, 0, ',', '.'),
                    'total_collected' => $campaign->total_collected,
                    'total_collected_formatted' => number_format($campaign->total_collected, 0, ',', '.'),
                    'expired' => $campaign->expired,
                    'category' => $campaign->category ? $campaign->category->name : null,
                    'status' => $campaign->status,
                    'donors' => $campaign->donations()->where('status_id', 2)->count(),
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'current_page' => $campaigns->currentPage(),
                'last_page' => $campaigns->lastPage(),
                'per_page' => $campaigns->perPage(),
                'total' => $campaigns->total(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data: ' . $e->getMessage(),
            ], 500);
        }
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

             Donation::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Donasi berhasil dikirim, menunggu verifikasi admin.',
                'data' => $data,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim donasi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Data untuk halaman Home
     */
    public function home()
    {
        try {
            $campaigns = Campaign::with('category')
                ->where('status', 'active')
                ->where(function ($q) {
                    $q->whereNull('expired')
                        ->orWhere('expired', '>=', now());
                })
                ->latest()
                ->paginate(3); // 3 per halaman

            // Map data
            $data = collect($campaigns->items())->map(function ($c) {
                $daysLeft = $c->expired ? now()->diffInDays($c->expired) : null;
                $progress = $c->goal_amount ? ($c->total_collected / $c->goal_amount * 100) : 0;

                return [
                    'id' => $c->id,
                    'title' => $c->title,
                    'slug' => $c->slug,
                    'image' => $c->image ? Storage::url($c->image) : null,
                    'goal_amount' => $c->goal_amount,
                    'goal_amount_formatted' => number_format($c->goal_amount, 0, ',', '.'),
                    'total_collected' => $c->total_collected,
                    'total_collected_formatted' => number_format($c->total_collected, 0, ',', '.'),
                    'progress' => round($progress, 2),
                    'donors' => $c->donations()->where('status_id', 2)->count(),
                    'daysLeft' => $daysLeft,
                    'urgent' => ($daysLeft !== null && $daysLeft <= 7) || $progress >= 80,
                    'category' => $c->category ? $c->category->name : null,
                    'status' => $c->status,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'current_page' => $campaigns->currentPage(),
                'last_page' => $campaigns->lastPage(),
                'per_page' => $campaigns->perPage(),
                'total' => $campaigns->total(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data home: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tampilkan daftar kategori campaign
     */
    public function categories()
    {
        try {
            $categories = CategoriesCampaign::all();

            $data = $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data kategori: ' . $e->getMessage(),
            ], 500);
        }
    }
}
