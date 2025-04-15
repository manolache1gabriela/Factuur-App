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
        'btw_number' => $request->btw_number,
        'address' => $request->address,
        'add_btw' => $request->add_btw
        ]);
        return redirect()->back();
    }
}