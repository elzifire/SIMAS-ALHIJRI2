<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentZakat;
// use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\DB;

class PaymentZakatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:payment-zakat.index|payment-zakat.update']);
    }

    public function index()
    {
        $payments = PaymentZakat::latest()->when(request()->q, function ($payments) {
            $payments = $payments->where('name', 'like', '%' . request()->q . '%');
        })->paginate(6);

        return view('admin.payment-zakat.index', compact('payments'));
    }

    public function update(Request $request, PaymentZakat $paymentZakat)
    {
        DB::beginTransaction();

        try {
            $paymentZakat->is_verified = true;
            $paymentZakat->save();

            // Optional: Simpan log atau update tabel lain di sini

            DB::commit();

            return redirect()->route('admin.payment-zakat.index')
                ->with('success', 'Pembayaran berhasil di-ACC.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.payment-zakat.index')
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }
}
