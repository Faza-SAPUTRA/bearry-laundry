<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class Invoice extends Controller
{

    public function getStatus($id_transaksi)
{
    $transaksi = Transaksi::find($id_transaksi);

    if (!$transaksi) {
        return response()->json(['error' => 'Transaksi tidak ditemukan.'], 404);
    }

    return response()->json([
        'id_transaksi' => $transaksi->id_transaksi,
        'status' => $transaksi->status
    ]);
}
    /**
     * Menampilkan invoice berdasarkan id_transaksi
     */
    public function search(Request $request)
    {
        $id_transaksi = $request->input('id_transaksi');
        $transaksi = Transaksi::with(['customer', 'detailTransaksi.jenisCucian'])
            ->find($id_transaksi);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        return view('pdf.invoice', compact('transaksi'));
    }

    /**
     * Download invoice dalam format PDF
     */
    public function download($id_transaksi)
    {
        $transaksi = Transaksi::with(['customer', 'detailTransaksi.jenisCucian'])
            ->find($id_transaksi);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $pdf = Pdf::loadView('pdf.invoice', compact('transaksi'));

        return response()->streamDownload(
            fn() => print($pdf->output()),
            "invoice-{$id_transaksi}.pdf"
        );
    }


    public function validateTransaction(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transaksi,id_transaksi',
            'phone_number' => 'required'
        ]);

        $transaksi = Transaksi::with('customer')->find($request->transaction_id);

        if ($transaksi && $transaksi->customer->phone === $request->phone_number) {
            return response()->json(['valid' => true]);
        }

        return response()->json(['valid' => false]);
    }
}
