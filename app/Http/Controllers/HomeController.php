<?php

namespace Hotels\Http\Controllers;

use Illuminate\Http\Request;
use Hotels\Hotel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::all();

        return view('hotels.index')->with('AllHotels', $hotels);
    }
}
