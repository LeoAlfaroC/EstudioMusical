<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ReservationDetails;
use App\Mail\ReservationCreated;
use App\Models\Reservation;
use App\Models\Instrument;
use App\Models\Category;
use App\Models\Room;
use Carbon\Carbon;
use Auth;
use DB;

class ReservationController extends Controller
{
    public function create()
    {
        return view('reservations.create');
    }

    public function search(Request $request)
    {
        $request->validate([
            'day' => 'required|date_format:Y-m-d|after:-1 day',
            'hour' => 'required|date_format:H:i',
        ]);

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
        // TO-DO find a better way to avoid repeating code
        $room = Room::find($request->room_id)->with(['reservations' => function ($query) use ($request) {
                        $query->where('day', '=', $request->day)
                            ->whereRaw('CAST(? AS TIME) < ADDTIME(from_hour, SEC_TO_TIME((duration*3600)-1))', [$request->hour])
                            ->orderBy('day')
                            ->orderBy('from_hour')
                            ->first();
                    }])->first();
        
        if($room->reservations->count() == 0)
            $max_hours = \Carbon\Carbon::parse(env('CLOSING_TIME'));
        else
            $max_hours = \Carbon\Carbon::parse($room->reservations[0]->from_hour);

        $max_hours = $max_hours->subHours(Carbon::parse(session()->get('hour'))->format('H'))->subMinutes(Carbon::parse(session()->get('hour'))->format('i'));
        $max_hours = $max_hours->hour + round($max_hours->minute / 60, 2);

        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'duration' => 'required|numeric|min:0.5|max:' . $max_hours,
        ]);

        $new_reservation = new Reservation();

        $new_reservation->user_id = Auth::check() ? Auth::user()->id : null;
        $new_reservation->room_id = $request->room_id;
        $new_reservation->day = session()->get('day');
        $new_reservation->from_hour = session()->get('hour');
        $new_reservation->duration = $request->duration;
        $new_reservation->confirmed = false;

        $new_reservation->save();

        session(['reservation_id' => $new_reservation->id]);

        return redirect(route('reserve_choose'))->with('reserve_saved', true);
    }

    public function choose(Request $request)
    {
        $categories = Category::all();
        $instruments = DB::select("SELECT a.id, a.name, b.id instrument_id, b.description, (b.stock - ifnull(c.en_uso, 0)) stock FROM categories a INNER JOIN instruments b ON a.id=b.category_id LEFT JOIN ( select `reservation_details`.`instrument_id`, SUM(quantity) en_uso from `reservation_details` where exists (select * from `reservations` where `reservation_details`.`reservation_id` = `reservations`.`id` and `day` = ? and CAST(? AS TIME)BETWEEN from_hour AND ADDTIME(from_hour, SEC_TO_TIME((duration*3600)-1)) and `confirmed` = true) group by `instrument_id`) c ON b.id=c.instrument_id where (b.stock - ifnull(c.en_uso, 0)) > 0 ORDER BY a.id", [session()->get('day'), session()->get('hour')]);

        return view('reservations.instruments')->with(['categories' => $categories, 'instruments' => $instruments]);
    }

    public function save_instruments(Request $request)
    {
        if(session()->has('reservation_id'))
        {
            $request->validate([
                'instruments' => 'required|array|min:1',
                'instruments.*' => 'exists:instruments,id',
            ]);

            DB::transaction(function () use($request) {
                foreach($request->instruments as $instrument)
                {
                    $new_detail = new ReservationDetails();
                    $new_detail->reservation_id = session()->get('reservation_id');
                    $new_detail->instrument_id = $instrument;
                    $quantity = 'quantity_' . $instrument;
                    $new_detail->quantity = $request->$quantity;

                    $new_detail->save();
                }
            });
        }
   
        return redirect(route('reserve_complete'));
    }

    public function complete()
    {
        if(session()->has('reservation_id'))
        {
            // We can safely assume the user has logged in (auth middleware) and proceed to update
            // their unconfirmed reservation (and send them an email)
            $reservation = Reservation::withoutGlobalScopes()->find(session()->get('reservation_id'));
            $reservation->user_id = Auth::user()->id;
            $reservation->confirmed = true;
            $reservation->save();

            Mail::to(Auth::user()->email)->send(new ReservationCreated($reservation->load('room')));

            session()->forget('reservation_id');

            return redirect(route('home'))->with('reserve_saved', true);
        }
        
        return redirect(route('home'));
    }
}
