<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::orderBy('id')->get();
        return view('payments.index', compact('payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'tipe' => 'required|in:bank,ewallet,qris',
            'nomor' => 'nullable|string|max:50',
            'atas_nama' => 'nullable|string|max:100',
        ]);

        Payment::create([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
            'nomor' => $request->nomor,
            'atas_nama' => $request->atas_nama,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('payments.index')
            ->with('success', 'Payment berhasil ditambahkan');
    }

    public function toggle($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'is_active' => ! $payment->is_active
        ]);

        return back()->with('success', 'Status payment berhasil diubah');
    }
}
