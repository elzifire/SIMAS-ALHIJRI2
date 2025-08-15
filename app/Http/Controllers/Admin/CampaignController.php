<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:campaigns.index|campaigns.create|campaigns.edit|campaigns.delete']);
    }

    private function parseMoney(?string $value): ?string
    {
        if ($value === null) return null;
        // buang semua kecuali angka, koma, titik, minus
        $v = preg_replace('/[^\d,\.\-]/', '', $value);
        // hapus pemisah ribuan (.)
        $v = str_replace('.', '', $v);
        // ganti koma jadi titik (desimal)
        $v = str_replace(',', '.', $v);
        // pastikan hasilnya numeric
        return is_numeric($v) ? $v : null;
    }

    public function index()
    {
        $campaigns = Campaign::latest()
            ->when(request()->q, function ($query) {
                return $query->where('title', 'like', '%' . request()->q . '%'); // Perbaiki query dari 'name' ke 'title'
            })
            ->paginate(10);

        return view('admin.campaign.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaign.create');
    }

    public function store(Request $request)
    {
        $this->middleware('permission:campaigns.create');

         // NORMALISASI DULU sebelum validate
        $request->merge([
            'goal_amount'     => $this->parseMoney($request->goal_amount),
            'total_collected' => 0, // default
        ]);

        $request->validate([
            'title'         => 'required|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'goal_amount'   => 'required|numeric|min:0',
            'description'   => 'required|string',
            'expired'       => 'required|date',
            'category_id'   => 'required|exists:categories_campaign,id',
            'bank_info'     => 'nullable|string',
            'status'        => 'required|string|max:50',
        ]);

        $data = $request->except(['image']);
        $data['slug'] = Str::slug($request->title); // Generate slug from title
        $data['total_collected'] = 0; // Default total_collected to 0

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('campaigns', 'public');
        }

        $campaign = Campaign::create($data);

        if ($campaign) {
            return redirect()->route('admin.campaign.index')
                ->with('success', 'Kampanye berhasil dibuat.');
        } else {
            return redirect()->route('admin.campaign.index')
                ->with('error', 'Kampanye gagal dibuat.');
        }
    }

    public function edit(Campaign $campaign)
    {
        return view('admin.campaign.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->middleware('permission:campaigns.edit');

        // NORMALISASI DULU sebelum validate
        $request->merge([
            'goal_amount' => $this->parseMoney($request->goal_amount),
        ]);

        $request->validate([
            'title'         => 'required|string|max:255',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'goal_amount'   => 'required|numeric|min:0',
            'description'   => 'required|string',
            'expired'       => 'required|date',
            'category_id'   => 'required|exists:categories_campaign,id',
            'bank_info'     => 'nullable|string',
            'status'        => 'required|string|max:50',
        ]);

        $data = $request->except(['image']);
        $data['slug'] = Str::slug($request->title); // Update slug based on title

        if ($request->hasFile('image')) {
            if ($campaign->image && Storage::disk('public')->exists($campaign->image)) {
                Storage::disk('public')->delete($campaign->image);
            }
            $data['image'] = $request->file('image')->store('campaigns', 'public');
        }

        $updated = $campaign->update($data);

        if ($updated) {
            return redirect()->route('admin.campaign.index')
                ->with('success', 'Kampanye berhasil diperbarui.');
        } else {
            return redirect()->route('admin.campaign.index')
                ->with('error', 'Kampanye gagal diperbarui.');
        }
    }

    public function destroy(Campaign $campaign)
    {
        $this->middleware('permission:campaigns.delete');

        if ($campaign->image && Storage::disk('public')->exists($campaign->image)) {
            Storage::disk('public')->delete($campaign->image);
        }

        $campaign->delete();

        return redirect()->route('admin.campaign.index')
            ->with('success', 'Kampanye berhasil dihapus.');
    }
}
