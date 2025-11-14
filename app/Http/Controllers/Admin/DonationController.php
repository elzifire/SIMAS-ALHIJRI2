<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Status;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Campaign;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:donations.index|donations.create|donations.edit|donations.delete']);
    }

    public function index()
    {
        $donations = Donation::with(['campaign', 'user', 'status'])
            ->latest()
            ->when(request()->q, function ($query) {
                return $query->where('name', 'like', '%' . request()->q . '%');
            })
            ->paginate(10);

        return view('admin.donation.index', compact('donations'));
    }

    public function create()
    {
        return view('admin.donation.create');
    }

    public function store(Request $request)
    {
        $this->middleware('permission:donations.create');

        $request->merge([
            'amount' => preg_replace('/[^0-9]/', '', $request->amount)
        ]);

        $request->validate([
            'name'           => 'required|string|max:255',
            'phone_number'   => 'nullable|string|max:20',
            'donation_type'  => 'nullable|string|max:50',
            'campaign_id'    => 'required|exists:campaigns,id',
            'status_id'      => 'required|exists:statuses,id',
            'amount'         => 'required|numeric|min:0',
            'proof_image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        return DB::transaction(function () use ($request) {
            $data = $request->except(['proof_image']);
            $data['status_id'] = Status::where('name', 'approved')->value('id'); // Default ke approved

            if ($request->hasFile('proof_image')) {
                $data['proof_image'] = $request->file('proof_image')->store('donations/proofs', 'public');
            }

            $donation = Donation::create($data);

            // Update total_collected di campaign terkait
            $campaign = $donation->campaign;
            $campaign->total_collected = $campaign->donations()->whereHas('status', function ($query) {
                $query->where('name', 'approved');
            })->sum('amount');
            $campaign->save();

            return redirect()->route('admin.donation.index')
                ->with('success', 'Donasi berhasil dibuat.');
        }, 5); // Retry 5 kali jika terjadi deadlock
    }

    public function edit($id)
    {
        $donation = Donation::findOrFail($id);
        $campaigns = Campaign::all();
        $statuses = Status::all();
        $rejectedStatusId = $statuses->where('name', 'rejected')->first();

        return view('admin.donation.edit', compact('donation', 'campaigns', 'statuses', 'rejectedStatusId'));
    }


    public function update(Request $request, Donation $donation)
    {
        $this->middleware('permission:donations.edit');

        $request->merge([
            'amount' => preg_replace('/[^0-9]/', '', $request->amount)
        ]);

        $request->validate([
            'name'           => 'required|string|max:255',
            'phone_number'   => 'nullable|string|max:20',
            'donation_type'  => 'nullable|string|max:50',
            'campaign_id'    => 'required|exists:campaigns,id',
            'status_id'      => 'required|exists:statuses,id',
            'rejected_reason' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $status = Status::find($request->status_id);
                    if ($status && $status->name === 'rejected' && empty($value)) {
                        $fail('Alasan penolakan wajib diisi jika status adalah rejected.');
                    }
                },
            ],
            'amount'         => 'required|numeric|min:0',
            'proof_image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        return DB::transaction(function () use ($request, $donation) {
            $data = $request->except(['proof_image']);

            if ($request->hasFile('proof_image')) {
                if ($donation->proof_image && Storage::disk('public')->exists($donation->proof_image)) {
                    Storage::disk('public')->delete($donation->proof_image);
                }
                $data['proof_image'] = $request->file('proof_image')->store('donations/proofs', 'public');
            }

            $updated = $donation->update($data);

            // Update total_collected di campaign terkait
            $campaign = $donation->campaign;
            $campaign->total_collected = $campaign->donations()->whereHas('status', function ($query) {
                $query->where('name', 'approved');
            })->sum('amount');
            $campaign->save();

            if ($updated) {
                return redirect()->route('admin.donation.index')
                    ->with('success', 'Donasi berhasil diperbarui.');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal memperbarui donasi, silakan coba lagi.')
                    ->withInput();
            }
        }, 5); // Retry 5 kali jika terjadi deadlock
    }

    public function destroy(Donation $donation)
    {
        $this->middleware('permission:donations.delete');

        return DB::transaction(function () use ($donation) {
            if ($donation->proof_image && Storage::disk('public')->exists($donation->proof_image)) {
                Storage::disk('public')->delete($donation->proof_image);
            }

            $campaign = $donation->campaign;
            $donation->delete();

            // Update total_collected di campaign terkait
            $campaign->total_collected = $campaign->donations()->whereHas('status', function ($query) {
                $query->where('name', 'approved');
            })->sum('amount');
            $campaign->save();

            return redirect()->route('admin.donation.index')
                ->with('success', 'Donasi berhasil dihapus.');
        }, 5); // Retry 5 kali jika terjadi deadlock
    }
}
