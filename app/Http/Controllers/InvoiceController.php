<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

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
        return redirect()->back();
    }
}
