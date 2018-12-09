<?php

namespace Hotels\Http\Controllers;

use Illuminate\Http\Request;
use Hotels\Hotel;
use Hotels\Login;
use Hotels\User;
use Auth;


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
        //
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
        $log = new Login;
        $log->user_id = $_GET['user_id'];
        $log->hotel_id = $_GET['hotel_id'];
        $log->save();

        $hotel = Hotel::find($_GET['hotel_id']);
        $new_places = $hotel->filled_places + 1;
        $hotel->filled_places = $new_places;
        $hotel->save();

        return redirect('/hotels/')->with('success', 'You successfully logged to the hotel!');
    }

    public function hotellogout()
    {
        $login = Login::where('hotel_id', $_GET['hotel_id']);
        $login->delete();

        $hotel = Hotel::find($_GET['hotel_id']);
        $new_places = $hotel->filled_places - 1;
        $hotel->filled_places = $new_places;
        $hotel->save();
        
        return redirect('/hotels/')->with('success', 'You successfully logged out of the hotel!');
    }
}
