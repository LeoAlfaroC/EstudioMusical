<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Instrument;

class InstrumentController extends Controller
{
    public function viewAll()
    {
        $instruments = Instrument::all();

        return view('backend.instruments.viewall')->with('instruments', $instruments);
    }

    public function view($id)
    {
        $instrument = Instrument::find($id);

        return view('backend.instruments.view')->with('instrument', $instrument);
    }

    public function edit($id)
    {
        $instrument = Instrument::find($id);

        return view('backend.instruments.edit')->with('instrument', $instrument);
    }

    public function save(Request $request)
    {
        $instrument = Instrument::find($request->instrument_id);
        $instrument->description = $request->description;

        $instrument->save();

        return redirect(route('instruments'))->with('saved', true);
    }
}
