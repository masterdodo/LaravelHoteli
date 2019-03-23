<?php

namespace Hotels\Http\Controllers;

use Illuminate\Http\Request;
use Hotels\Hotel;
use Hotels\Login;
use Hotels\User;
use Auth;
use Illuminate\Support\Facades\DB;


class HotelsController extends Controller
{
    /**
     * Display a listing of the resource.
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

        if(isset($_GET['query']))
        {
            $AllHotels = Hotel::where('start_date', '>', $today_date)
            ->where(function($querystring)
            {
                $query = $_GET['query'];
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
                    $querystring->orwhere('name', 'LIKE', '%' . $query . '%')
                            ->orWhere('address', 'LIKE', '%' . $query . '%')
                            ->orWhere('description', 'LIKE', '%' . $query . '%')
                            ->orWhere('user_id', $user_ids);
            })
            ->get();
        }

        return view('hotels.index', compact('AllHotels', 'Logins', 'AllUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::guest())
        {
            return redirect()->action('HotelsController@index');
        }
        else
        {
            return view('hotels.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:200',
            'address' => 'required|max:200',
            'price' => 'required|numeric',
            'all_places' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'image' => 'image|required',
            'description' => 'required|max:200',
            'user_id' => 'required|numeric|min:0'
        ]);

        $photoName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $photoName);

        $hotel = new Hotel;
        $hotel->name = $request->get('name');
        $hotel->address = $request->get('address');
        $hotel->price = $request->get('price');
        $hotel->filled_places = 0;
        $hotel->all_places = $request->get('all_places');
        $hotel->start_date = $request->get('start_date');
        $hotel->end_date = $request->get('end_date');
        $hotel->image = $photoName;
        $hotel->description = $request->get('description');
        $hotel->user_id = $request->get('user_id');
        $hotel->free_wifi = $request->get('free_wifi') ? $request->get('free_wifi') : "0";
        $hotel->airport_shuttle = $request->get('airport_shuttle') ? $request->get('airport_shuttle') : "0";
        $hotel->non_smoking_rooms = $request->get('non_smoking_rooms') ? $request->get('non_smoking_rooms') : "0";
        $hotel->lift = $request->get('lift') ? $request->get('lift') : "0";
        $hotel->air_conditioning = $request->get('air_conditioning') ? $request->get('air_conditioning') : "0";
        $hotel->parking = $request->get('parking') ? $request->get('parking') : "0";
        $hotel->family_rooms = $request->get('family_rooms') ? $request->get('family_rooms') : "0";
        $hotel->fitness_centre = $request->get('fitness_centre') ? $request->get('fitness_centre') : "0";
        $hotel->spa_and_wellness_centre = $request->get('spa_and_wellness_centre') ? $request->get('spa_and_wellness_centre') : "0";
        $hotel->swimming_pool = $request->get('swimming_pool') ? $request->get('swimming_pool') : "0";
        $hotel->bar = $request->get('bar') ? $request->get('bar') : "0";
        $hotel->outdoor_pool = $request->get('outdoor_pool') ? $request->get('outdoor_pool') : "0";
        $hotel->room_service = $request->get('room_service') ? $request->get('room_service') : "0";
        $hotel->heating = $request->get('heating') ? $request->get('heating') : "0";
        $hotel->terrace = $request->get('terrace') ? $request->get('terrace') : "0";
        $hotel->garden = $request->get('garden') ? $request->get('garden') : "0";
        $hotel->save();

        return redirect('/hotels')->with('success', 'Hotel has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Logins = Login::where('hotel_id', $id)->get();
        $Logged_user_ids = array();
        foreach($Logins as $Log)
        {
            $Logged_user_ids[] = $Log->user_id;
        }
        $Users = User::whereIn('id', $Logged_user_ids)->get();
        $Hotel = Hotel::find($id);
        return view('hotels.show', compact('Logins', 'Users', 'Hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::guest())
        {
            return redirect()->action('HotelsController@index');
        }
        else
        {
            $hotel = Hotel::find($id);
            return view('hotels.edit', compact('hotel', 'id'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:200',
            'address' => 'required|max:200',
            'price' => 'required|max:10',
            'all_places' => 'required|max:200',
            'start_date' => 'required|max:200',
            'end_date' => 'required|max:200',
            'description' => 'required|max:200'
        ]);

        $hotel = Hotel::find($id);
        if(isset($request->image))
        {
            $photoName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $photoName);
            $hotel->image = $photoName;
        }
        $hotel->name = $request->get('name');
        $hotel->address = $request->get('address');
        $hotel->price = $request->get('price');
        $hotel->all_places = $request->get('all_places');
        $hotel->start_date = $request->get('start_date');
        $hotel->end_date = $request->get('end_date');
        $hotel->description = $request->get('description');
        $hotel->save();

        return redirect('/hotels/')->with('success', 'Hotel was edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hotel = Hotel::find($id);
        $hotel->delete();
        return redirect('/hotels/')->with('success', 'Hotel was successfully deleted!');
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|max:200',
        ]);

        $AllHotels = Hotel::where('name', 'like', '%' . $request->get('search') . '%');
    }

    public function hotellogin()
    {
        if($_GET['capacity']=="" || $_GET['capacity']==0)
        {
            return redirect('/hotels/');
        }
        else
        {
            $log = new Login;
            $log->user_id = $_GET['user_id'];
            $log->hotel_id = $_GET['hotel_id'];
            $log->capacity = $_GET['capacity'];

            $hotel = Hotel::find($_GET['hotel_id']);
            $new_places = $hotel->filled_places + $_GET['capacity'];
            if($new_places <= $hotel->all_places)
            {
                $hotel->filled_places = $new_places;
                $hotel->save();
                $log->save();
            }
            else
            {
                return back()->with('error-field', 'Not enough spaces left!');
            }
        }

        return redirect('/hotels/')->with('success', 'You successfully logged ' . $_GET['capacity'] . ' people to the hotel!');
    }

    public function hotellogout()
    {
        $user_id = Auth::user()->id;
        $login1 = Login::where('hotel_id', $_GET['hotel_id'])->where('user_id', $user_id)->value('capacity');
        $capacity = $login1;
        $login = Login::where('hotel_id', $_GET['hotel_id'])->where('user_id', $user_id);
        $login->delete();

        $hotel = Hotel::find($_GET['hotel_id']);
        $new_places = $hotel->filled_places - $capacity;
        $hotel->filled_places = $new_places;
        $hotel->save();

        return redirect('/hotels/')->with('success', 'You successfully logged ' . $capacity . ' out of the hotel!');
    }

    public function hotelpublisherlogout()
    {
        $login1 = Login::where('hotel_id', $_GET['hotel_id'])->where('user_id', $_GET['user_id'])->value('capacity');
        $capacity = $login1;
        $login = Login::where('hotel_id', $_GET['hotel_id'])->where('user_id', $_GET['user_id']);
        $login->delete();

        $hotel = Hotel::find($_GET['hotel_id']);
        $new_places = $hotel->filled_places - $capacity;
        $hotel->filled_places = $new_places;
        $hotel->save();

        return redirect()->back()->with('success', 'You successfully logged out the user.');
    }

    public function editorallhotels()
    {
        if(Auth::guest())
        {
            return redirect()->action('HotelsController@index');
        }
        else
        {
            $user_id = Auth::user()->id;
            $Hotels = Hotel::where('user_id', $user_id)->get();

            return view('users.editorhotels', compact('Hotels'));
        }
    }
}
