<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Unit;
use Spatie\LaravelPdf\Facades\Pdf;

class InvoiceController extends Controller
{

    public function index(Request $request)
    {
        $clientId = $request->get('client_id', null);
        if (empty($clientId)) {
            $invoices = Invoice::whereBetween('updated_at', [Carbon::now()->subMonth(), Carbon::now()])
                ->with(['client'])
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $invoices = Invoice::where('client_id', $clientId)->orderBy('id', 'DESC')->paginate(10);
        }
        $clients = Client::where('deleted', false)->get();
        $clients->prepend((new Client())->setId(0)->setName('All clients'));

        return Inertia::render('Welcome', [
            'clients' => $clients,
            'invoices' => $invoices,
            'client_id' => $clientId
        ]);
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
        $clientName = str_replace(' ', '_', $invoice->client->name);

        $filename = strtolower($invoice->id . '_factuur_' . $clientName . '_' . Carbon::now()->format('Y_m_d_H:i') . '.pdf');
        $savedPdf = Pdf::view('pdfs.invoice', ['invoice' => $invoice])
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->noSandbox();
            })
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
