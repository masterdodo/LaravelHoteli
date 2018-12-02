<?php

namespace Hotels\Http\Controllers;

use Illuminate\Http\Request;
use Hotels\Hotel;
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
        $hotels = Hotel::all();
        $url = action('HotelsController@create');

        return view('hotels.index')->with('AllHotels', $hotels);
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

        /*$request->validate([
            'name' => 'required|max:200',
            'address' => 'required|max:200',
            'all_places' => 'required|max:200',
            'start_date' => 'required|max:200',
            'end_date' => 'required|max:200',
            'image' => 'image|required|max:1999',
            'description' => 'required|max:200',
            'user_id' => 'required'
        ]);*/

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
        $hotel = Hotel::find($id);
        return view('hotels.edit', compact('hotel', 'id'));
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
            'description' => 'required|max:200',
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

        return redirect('/hotels/')->with('success', 'Hotel was eddited successfully.');
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
        return redirect('/hotels/')->with('success', 'Hotel was successfully deleted.');
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|max:200',
        ]);
    }
}
