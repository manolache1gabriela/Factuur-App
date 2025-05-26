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
        $client = Client::create([
            'name' => $request->name,
            'btw_number' => $request->btw_number,
            'address' => $request->address,
            'has_btw' => $request->has_btw
        ]);
        return redirect()->back();
    }



    public function delete(Client $client)
    {

        $client->update([
            'deleted' => true
        ]);
        return redirect()->back();
    }
}
