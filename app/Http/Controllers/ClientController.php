<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(){
        $clients = Client::all();
        return response()->json($clients);
    }

    public function store(Request $request){
        $client = Client::create([
        'name' => $request->name,
        'btw' => $request->btw,
        'address' => $request->address,
        'add_btw' => $request->add_btw
        ]);
        var_dump(2);
        return response()->json($client);
    }
}