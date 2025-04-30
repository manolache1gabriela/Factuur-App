<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;

class InvoiceController extends Controller
{

    public function index()
    {
        $invoices = Invoice::all();
        return response()->json($invoices);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'currentClient' => 'required|exists:clients,id',
            'location' => 'required',
            'rows' => 'required'
        ]);


        $invoice = Invoice::create([
            'client_id' => $validated['currentClient'],
            'location' => $validated['location'],
            'data' => json_encode($validated['rows']),
        ]);

        return redirect()->route('home', ['client_id' => $validated['currentClient']]);
    }

    public function downloadInvoice(Invoice $invoice)
    {
        $filename = 'invoice_' . Carbon::now()->format('YYYY_m_d_HHii') . '.pdf';
        $savedPdf = Pdf::view('pdfs.invoice', ['invoice' => $invoice])
            ->format('a4')
            ->margins(0, 0, 0, 0, Unit::Pixel)
            ->name($filename);

        return $savedPdf;
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'currentClient' => 'required|exists:clients,id',
            'location' => 'required',
            'rows' => 'required'
        ]);

        $invoice->update([
            'client_id' => $validated['currentClient'],
            'location' => $validated['location'],
            'data' => json_encode($validated['rows']),
        ]);

        return redirect()->route('home', ['client_id' => $validated['currentClient']]);
    }
}