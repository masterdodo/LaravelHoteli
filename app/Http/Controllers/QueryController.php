<?php

namespace Hotels\Http\Controllers;

//use Illuminate\Http\Request;
use Request;
use Hotels\Hotel;
use Hotels\Login;
use Hotels\User;
use Auth;

class QueryController extends Controller
{
    public function search(Request $request)
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

        $query = Request::input('search');

        $Providers = User::where('name', 'LIKE', '%' . $query . '%')->get();
        $user_ids = array();
        foreach($Providers as $Provider)
        {
            $user_ids[] = $Provider->id;
        }
        if(empty($user_ids))
        {
            $user_ids[] = 0;
        }
        $AllHotels = Hotel::where('name', 'LIKE', '%' . $query . '%')
        ->orWhere('address', 'LIKE', '%' . $query . '%')
        ->orWhere('description', 'LIKE', '%' . $query . '%')
        ->orWhere('user_id', $user_ids)->get();
        $user_ids = array();

        $AllUsers = User::all();

        // returns a view and passes the view the list of articles and the original query.
        return view('hotels.index', compact('AllHotels', 'Logins', 'AllUsers', 'query'));
    }
}
