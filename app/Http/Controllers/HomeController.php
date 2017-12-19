<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latest_events = Reservation::orderBy('created_at', 'desc')->take(4)->get();
        return view('welcome')->with('events', $latest_events);
    }

    public function home()
    {
        $next_reservation = Reservation::with('room')->where('user_id', Auth::user()->id)
                                                    ->where('day', '>=', DB::raw('CURDATE()'))
                                                    ->where('from_hour', '>=', DB::raw('CURTIME()'))
                                                    ->orderBy('day', 'asc')
                                                    ->orderBy('from_hour', 'asc')->first();

        $past_reservations = Reservation::with('room')->where('user_id', Auth::user()->id)->where('day', '<', DB::raw('CURDATE()'))
                                                    ->orWhere(function ($query) {
                                                        $query->where('day', '=', DB::raw('CURDATE()'))
                                                            ->where('from_hour', '<=', DB::raw('CURTIME()'));
                                                    })->orderBy('day', 'desc')
                                                    ->orderBy('from_hour', 'desc')->get();

        return view('home')->with(['reservation' => $next_reservation, 'past_reservations' => $past_reservations]);
    }
}
