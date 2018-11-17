@extends('layouts.app')
@section('content')

<p>Index Site</p>

<table>
@foreach($AllHotels as $Hotel)
    <div class="hotel-index-div">
        <p>Hotel name: {{$Hotel->name}}</p>
        <p>Hotel address: {{$Hotel->address}}</p>
        <img src="{{$Hotel->image}}" alt="hotel_image" width="200">
        <p>First day of accommodation: {{$Hotel->start_day}}</p>
        <p>Last day of accommodation: {{$Hotel->end_date}}</p>
        <p>Hotel description: {{$Hotel->description}}</p>
    </div>
@endforeach
</table>

@endsection