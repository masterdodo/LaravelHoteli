<?php

namespace Hotels\Http\Controllers;

use Illuminate\Http\Request;
use Hotels\Hotel;
use Auth;

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
        if(Auth::user())
        {
            $user_id = Auth::user()->id;
            $Logins = \DB::table('logins')->where('user_id', $user_id)->get();
        }
        else
        {
            $Logins = false;
        }
        $today_date = date('Y-m-d H:i:s');
        $AllHotels = Hotel::where('start_date', '>', $today_date)->get();
        $AllUsers = User::all();

        return view('hotels.index', compact('AllHotels', 'Logins', 'AllUsers'));
    }
}
