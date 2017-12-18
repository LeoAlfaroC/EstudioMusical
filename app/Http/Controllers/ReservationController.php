<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReservationDetails;
use App\Models\Reservation;
use App\Models\Instrument;
use App\Models\Room;
use Carbon\Carbon;
use Auth;
use DB;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('reservations.create');
    }

    public function search(Request $request)
    {
        session(['day' => $request->day]);
        session(['hour' => $request->hour]);

        // Rooms with no reservations that start before and end after the desired hour
        // It then queries the next reservation closest to the desired hour (to calculate the available hours to reserve)
        $available_rooms = Room::whereDoesntHave('reservations', function ($query) use ($request) {
                $query->where('day', '=', $request->day)
                      ->whereRaw('CAST(? AS TIME) BETWEEN from_hour AND ADDTIME(from_hour, SEC_TO_TIME((duration*3600)-1))', [$request->hour]);
            })->orderBy('room_number')->with(['reservations' => function ($query) use ($request) {
                $query->where('day', '=', $request->day)
                      ->whereRaw('CAST(? AS TIME) < ADDTIME(from_hour, SEC_TO_TIME((duration*3600)-1))', [$request->hour])
                      ->orderBy('day')
                      ->orderBy('from_hour')
                      ->first();
            }])->get();

        $desired_hour = Carbon::parse($request->hour);

        // Calculates the room's available hours with the desired hour and the starting hour of the room's next reservation (if there's none, it'll use the closing time -set in the env file- of the studio)
        foreach($available_rooms as $room)
        {
            if($room->reservations->count() == 0)
            {
                $max_hours = \Carbon\Carbon::parse(env('CLOSING_TIME'));
            }
            else
            {
                $max_hours = \Carbon\Carbon::parse($room->reservations[0]->from_hour);
            }

            $max_hours = $max_hours->subHours($desired_hour->format('H'))->subMinutes($desired_hour->format('i'));
            $room->available_hours = $max_hours;

            $max_hours = $max_hours->hour + round($max_hours->minute / 60, 2);
            $room->available_hours_int = $max_hours;
        }

        return view('reservations.available_rooms')->with(['rooms' => $available_rooms, 'desired_hour' => $desired_hour]);
    }

    public function save(Request $request)
    {
        $new_reservation = new Reservation();

        $new_reservation->user_id = Auth::user()->id;
        $new_reservation->room_id = $request->room_id;
        $new_reservation->day = session()->get('day');
        $new_reservation->from_hour = session()->get('hour');
        $new_reservation->duration = $request->duration;

        $new_reservation->save();

        session(['reservation_id' => $new_reservation->id]);

        return redirect(route('reserve_choose'))->with('reserve_saved', true);
    }

    public function choose(Request $request)
    {
        $intruments = Instrument::whereDoesntHave('reservations', function ($query) {
            $query->whereHas('parent', function ($query) {
                $query->where('day', session()->get('day'))
                ->whereRaw('CAST(? AS TIME) BETWEEN from_hour AND ADDTIME(from_hour, SEC_TO_TIME((duration*3600)-1))', [session()->get('hour')]);
            });
        })->get();

        return view('reservations.instruments')->with('intruments', $intruments);
    }

    public function save_instruments(Request $request)
    {
        // TO-DO: Put inside transaction
        foreach($request->instruments as $instrument)
        {
            $new_detail = new ReservationDetails();
            $new_detail->reservation_id = session()->get('reservation_id');
            $new_detail->instrument_id = $instrument;

            $new_detail->save();
        }

        return redirect(route('home'))->with('reserve_saved', true);        
    }
}
