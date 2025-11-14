<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentZakat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentZakatController extends Controller
{
    public function store(Request $request)
    {
        // Validasi captcha
        // $isVerified = filter_var($request->input('is_verified'), FILTER_VALIDATE_BOOLEAN);
        // if (!$isVerified) {
        //     return response()->json([
        //         'status'  => false,
        //         'message' => 'Verifikasi captcha gagal',
        //         'errors'  => ['captcha' => 'Captcha not verified']
        //     ], 422);
        // }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:100',
            'phone'      => 'required|string|max:20',
            'zakat_type' => 'required|in:penghasilan,fitrah,maal,emas,perdagangan',
            'amount'     => 'required|numeric|min:0',
            'proof'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'note'       => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $proofPath = null;
            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('payment_zakat_proofs', 'public');
                if (!$proofPath) {
                    throw new \Exception('Gagal mengunggah bukti transfer');
                }
            }

            $payment = PaymentZakat::create([
                'name'        => $request->name,
                'phone'       => $request->phone,
                'zakat_type'  => $request->zakat_type,
                'amount'      => $request->amount,
                'proof'       => $proofPath,
                'note'        => $request->note,
                'is_verified' => false
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Pembayaran zakat berhasil disimpan',
                'data'    => $payment
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to save zakat payment: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan pembayaran zakat',
                'errors'  => ['server' => $e->getMessage()]
            ], 500);
        }
    }
}