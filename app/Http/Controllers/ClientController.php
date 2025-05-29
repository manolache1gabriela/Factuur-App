<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('deleted', false)->get();
        return response()->json($clients);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'btw_number' => 'exclude_unless:has_btw,true|required|string',
            'address' => 'required|string',
            'has_btw' => 'required|boolean'
        ]);
        if (!$validated['has_btw']) {
            $validated['btw_number'] = null;
        }

        $client = Client::create($validated);

        return redirect()->back();
    }

    public function update(Request $request, Client $client)
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'btw_number' => 'exclude_unless:has_btw,true|required|string',
            'address' => 'required|string',
            'has_btw' => 'required|boolean'
        ]);

        if (!$validated['has_btw']) {
            $validated['btw_number'] = null;
        }

        $client->update($validated);

        return redirect()->back();
    }

    public function delete(Client $client)
    {

        $client->update([
            'deleted' => true
        ]);
        return redirect('/');
    }
}
