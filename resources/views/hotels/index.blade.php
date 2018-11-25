@extends('layouts.app')
@section('content')

<a href="{{action('HotelsController@create')}}" class="standard-btn">New Hotel</a>

<table>
@foreach($AllHotels as $Hotel)
    <div class="hotel-index-div">
        <p>Hotel name: {{$Hotel->name}}</p>
        <p>Hotel address: {{$Hotel->address}}</p>
        <img src="{{url('/images'). "/" . $Hotel->image}}" alt="hotel_image" width="200">
        <p>First day of accommodation: {{$start_date = date('d. m. Y', strtotime($Hotel->start_date))}}</p>
        <p>Last day of accommodation: {{$end_date = date('d. m. Y', strtotime($Hotel->end_date))}}</p>
        <p>Hotel description: {{$Hotel->description}}</p>
        <a href="{{ action('HotelsController@edit', ['id' => $Hotel->id]) }}">Edit Hotel</a>
    </div>
@endforeach
</table>

@endsection