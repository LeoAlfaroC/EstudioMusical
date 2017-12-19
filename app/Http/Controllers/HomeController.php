<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latest_events = Reservation::orderBy('created_at', 'desc')->get();
        return view('welcome')->with('events', $latest_events);
    }

    public function home()
    {
        return view('home');
    }
}
