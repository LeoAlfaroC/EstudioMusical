<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User as Client;

class ClientController extends Controller
{
    public function viewAll()
    {
        $clients = Client::where('is_admin', false)->get();

        return view('backend.clients.viewall')->with('clients', $clients);
    }

    public function view($id)
    {
        $client = Client::find($id);

        return view('backend.clients.view')->with('client', $client);
    }

    public function edit($id)
    {
        $client = Client::find($id);

        return view('backend.clients.edit')->with('client', $client);
    }

    public function save(Request $request)
    {
        $client = Client::find($request->client_id);
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;

        $client->save();

        return redirect(route('clients'))->with('saved', true);
    }
}
