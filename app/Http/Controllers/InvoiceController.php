<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'currentClient' => 'required|exists:clients,id',
            'rows' => 'required'
        ]);


        $invoice = Invoice::create([
            'client_id' => $validated['currentClient'],
            'data' => json_encode($validated['rows']),
        ]);

        Pdf::view('pdfs.invoice', ['invoice' => Invoice::with(['client'])->find(2025031)])->format('a4')->save('../storage/app/public/pdfs/invoice.pdf');
        $savedPdf = Pdf::view('pdfs.invoice', ['invoice' => $invoice])->format('a4')->margins(0, 0, 0, 0, Unit::Pixel)->name('invoice.pdf')->download();
        // return $savedPdf;
        // dd($savedPdf);
        return redirect()->back();
    }
}
