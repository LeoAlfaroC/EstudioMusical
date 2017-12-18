<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;

class RoomController extends Controller
{
    public function viewAll()
    {
        $rooms = Room::all();

        return view('backend.rooms.viewall')->with('rooms', $rooms);
    }

    public function view($id)
    {
        $room = Room::find($id);

        return view('backend.rooms.view')->with('room', $room);
    }

    public function edit($id)
    {
        $room = Room::find($id);

        return view('backend.rooms.edit')->with('room', $room);
    }

    public function save(Request $request)
    {
        $room = Room::find($request->room_id);
        $room->room_number = $request->room_number;

        $room->save();

        return redirect(route('rooms'))->with('saved', true);
    }
}