@extends('layouts.app')

@section('content')
<div class="show-body">
<a href="{{route('home')}}" class="standard-btn" style="color: white;">Home</a><br />

@if(Auth::user()->editor == 1)
<br /><h2>Logged user</h2>
<div style="overflow:auto;">
<table border="1" class="table">
    <thead>
        <td>Name</td>
        <td>Email</td>
        <td>Capacity</td>
        <td>Date of log</td>
        <td>Logout</td>
    </thead>
@foreach ($Users as $Loged_user)
    <tr>
        <td>{{$Loged_user->email}}</td>
        <td>{{$Loged_user->name}}</td>
        @foreach ($Logins as $Log)
            @if ($Log->user_id == $Loged_user->id)
                <td>{{$Log->capacity}}</td>
                <td>{{ $Log->created_at->diffForHumans() }}</td>
                <td>
                    <form action="{{ action('HotelsController@hotelpublisherlogout') }}">
                        <input type="hidden" name="user_id" value="{{ $Loged_user->id }}">
                        <input type="hidden" name="hotel_id" value="{{ $Log->hotel_id }}">
                        <button class="link-to-button red-button" type="submit">Log Out</button>
                    </form>
                </td>
            @endif
        @endforeach
    </tr>
@endforeach
</table>
</div>
@elseif(Auth::user())
<br />
<div class="showhoteluser">
    <h1 style="text-align: center;">{{ $Hotel->name }}</h1>
    <img src="{{url('/images'). "/" . $Hotel->image}}" alt="hotel_image" class="showhotel-image">
    <p><b>Price: </b><span class="price-hotel"><b>{{$Hotel->price}} €</b></span></p>
    <p><b>Filled:</b> {{$Hotel->filled_places}}/{{$Hotel->all_places}} <b>Free places:</b> {{$Hotel->all_places - $Hotel->filled_places}} </p>
    <p><b>Hotel address:</b> {{$Hotel->address}}</p>
    <p><b>First day of accommodation:</b> {{$start_date = date('d. m. Y', strtotime($Hotel->start_date))}}</p>
    <p><b>Last day of accommodation:</b> {{$end_date = date('d. m. Y', strtotime($Hotel->end_date))}}</p>
    <p><b>Hotel description:</b><br /> {{$Hotel->description}}</p>
    <div class="hotel-props">
        <b>Special Features:</b><br />
        @if($Hotel->free_wifi == 1)
        <svg class="bk-icon -iconset-wifi hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><circle cx="64" cy="100" r="12"></circle><path d="M118.3 32.7A94.9 94.9 0 0 0 64 16 94.9 94.9 0 0 0 9.7 32.7a4 4 0 1 0 4.6 6.6A87 87 0 0 1 64 24a87 87 0 0 1 49.7 15.3 4 4 0 1 0 4.6-6.6zM87.7 68.4a54.9 54.9 0 0 0-47.4 0 4 4 0 0 0 3.4 7.2 47 47 0 0 1 40.6 0 4 4 0 0 0 3.4-7.2z"></path><path d="M104 50.5a81.2 81.2 0 0 0-80 0 4 4 0 0 0 4 7 73.2 73.2 0 0 1 72 0 4 4 0 0 0 4-7z"></path></svg> Free Wifi
        @endif
        @if($Hotel->airport_shuttle == 1)
        <svg class="bk-icon -iconset-shuttle hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M92 100a10 10 0 1 1-10 10 10 10 0 0 1 10-10zm-66 10a10 10 0 1 0 10-10 10 10 0 0 0-10 10zM16 56h88.2a8 8 0 0 1 7.6 5.5l7.8 26.3a8 8 0 0 1 .4 2.5V106a6 6 0 0 1-6 6h-6.1a16 16 0 1 0-31.8 0H52a16 16 0 1 0-31.8 0H16a8 8 0 0 1-8-8V64a8 8 0 0 1 8-8zm72 24l25 8-7-24H88zm-24 0h16V64H64zm-24 0h16V64H40zm-24 0h16V64H16zm28.2-44.6l8 4.5 4.4 8a.4.4 0 0 0 .6 0l1-1a.4.4 0 0 0 0-.3V37l6.5-5.9L76.1 46a1.4 1.4 0 0 0 2 .4l1-.5a1.4 1.4 0 0 0 .5-1.8L72 24.2l9-8.4a10.2 10.2 0 0 0 3-6.4A1.4 1.4 0 0 0 82.6 8a10.2 10.2 0 0 0-6.5 2.9L67.6 20l-19.8-7.5a1.4 1.4 0 0 0-1.8.6l-.5 1A1.4 1.4 0 0 0 46 16l15 11.5-5.8 6.2h-9.7a.4.4 0 0 0-.3.1l-1 1a.4.4 0 0 0 0 .6z"></path></svg> Airport Shuttle
        @endif
        @if($Hotel->non_smoking_rooms == 1)
        <svg class="bk-icon -iconset-nosmoking hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M64 8a56 56 0 1 0 56 56A56 56 0 0 0 64 8zm0 104a48 48 0 0 1-36.6-79l31 31H28v8h38.3L95 100.6A47.8 47.8 0 0 1 64 112zm36.6-17l-23-23H84v-8H69.7L33 27.4A48 48 0 0 1 100.6 95zM92 64h8v8h-8zm0-10c0-7.7-5.9-14-13.2-14H78a2 2 0 0 1-2-2 10 10 0 0 0-10-10h-8a2 2 0 0 1 0-4h8a14 14 0 0 1 13.8 12c9 .6 16.2 8.4 16.2 18a2 2 0 0 1-4 0zm-8 0a2 2 0 0 1-4 0 2 2 0 0 0-2-2h-3a15 15 0 0 1-15-15 2 2 0 0 1 4 0 11 11 0 0 0 11 11h3a6 6 0 0 1 6 6z"></path></svg> Non-smoking Rooms
        @endif
        @if($Hotel->lift == 1)
        <svg class="bk-icon -iconset-elevator hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M40 38a6 6 0 1 1 6-6 6 6 0 0 1-6 6zM28 48l2 19a2.8 2.8 0 0 0 .8 1.6l1.1 1.2a2.8 2.8 0 0 1 .8 1.6l2.1 22a2.7 2.7 0 0 0 2.7 2.6h5a2.7 2.7 0 0 0 2.6-2.5l2.2-22a2.8 2.8 0 0 1 .8-1.7l1-1.1A2.8 2.8 0 0 0 50 67l2-19c.2-1.6 0-3.1-2.3-3.8A60 60 0 0 0 40 43a60 60 0 0 0-9.6 1.3c-2.4.6-2.5 2-2.3 3.7zm50-16a6 6 0 1 0-6 6 6 6 0 0 0 6-6zM60 48l2 19a2.8 2.8 0 0 0 .8 1.6l1.1 1.2a2.8 2.8 0 0 1 .8 1.6l2.1 22a2.7 2.7 0 0 0 2.7 2.6h5a2.7 2.7 0 0 0 2.6-2.5l2.2-22a2.8 2.8 0 0 1 .8-1.7l1-1.1A2.8 2.8 0 0 0 82 67l2-19c.2-1.6 0-3.1-2.3-3.8A60 60 0 0 0 72 43a60 60 0 0 0-9.6 1.3c-2.4.6-2.5 2-2.4 3.7zm44 63a1 1 0 0 1-1 1H17a1 1 0 0 1-1-1V17a1 1 0 0 1 1-1h86a1 1 0 0 1 1 1v15h8V12a4 4 0 0 0-4-4H12a4 4 0 0 0-4 4v104a4 4 0 0 0 4 4h96a4 4 0 0 0 4-4V96h-8zm2.4-70.1L96.4 53a2 2 0 0 0 1.6 3h20a2 2 0 0 0 1.6-3l-10-12.1a2 2 0 0 0-3.2 0zM118 72H98a2 2 0 0 0-1.6 3l10 12.1a2 2 0 0 0 3.2 0l10-12.1a2 2 0 0 0-1.6-3z"></path></svg> Lift<br />
        @endif
        @if($Hotel->air_conditioning == 1)
        <svg class="bk-icon -iconset-snowflake hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M89.6 44.6L94 28.3a4 4 0 0 1 4.9-2.9 4 4 0 0 1 2.8 5l-2.3 8.5 7.7-4.4a4 4 0 0 1 5.5 1.4 4 4 0 0 1-1.5 5.5l-7.7 4.4 8.6 2.4a4 4 0 0 1 2.8 4.9 4 4 0 0 1-4.9 2.8l-16.3-4.4-15.5 9a4 4 0 0 1-5.5-1.5 4 4 0 0 1 1.5-5.5zM53.9 74.5a4 4 0 0 0 1.4-5.5 4 4 0 0 0-5.4-1.5l-15.6 9L18 72.2a4 4 0 0 0-5 2.8 4 4 0 0 0 2.9 5l8.4 2.2-7.5 4.3a4 4 0 0 0-1.4 5.5 4 4 0 0 0 5.4 1.5l7.8-4.5-2.4 8.8a4 4 0 0 0 2.9 4.9 4 4 0 0 0 4.9-2.9l4.4-16.4zM60 32.2V50a4 4 0 0 0 4 4 4 4 0 0 0 4-4V32l11.9-11.9a4 4 0 0 0 0-5.6 4 4 0 0 0-5.7 0L68 20.7V12a4 4 0 0 0-4-4 4 4 0 0 0-4 4v8.9l-6.4-6.4a4 4 0 0 0-5.6 0 4 4 0 0 0 0 5.7zM114.8 75a4 4 0 0 0-4.9-2.8l-16.3 4.3-15.5-9a4 4 0 0 0-5.5 1.5 4 4 0 0 0 1.5 5.5l15.5 8.9 4.3 16.4a4 4 0 0 0 4.9 2.8 4 4 0 0 0 2.8-4.9L99.3 89l7.7 4.5a4 4 0 0 0 5.5-1.5 4 4 0 0 0-1.5-5.4l-7.6-4.4 8.6-2.3a4 4 0 0 0 2.8-4.9zM68 95.8V78a4 4 0 0 0-4-4 4 4 0 0 0-4 4v18l-11.9 11.9a4 4 0 0 0 0 5.6 4 4 0 0 0 5.7 0l6.2-6.2v8.7a4 4 0 0 0 4 4 4 4 0 0 0 4-4v-8.9l6.4 6.4a4 4 0 0 0 5.6 0 4 4 0 0 0 0-5.7zM13.2 53a4 4 0 0 0 4.8 2.8l16.3-4.3 15.5 9a4 4 0 0 0 5.5-1.5 4 4 0 0 0-1.4-5.5l-15.5-8.9-4.3-16.4a4 4 0 0 0-5-2.8 4 4 0 0 0-2.8 4.9l2.3 8.7-7.7-4.5a4 4 0 0 0-5.4 1.5 4 4 0 0 0 1.4 5.5l7.6 4.3-8.5 2.3a4 4 0 0 0-2.9 4.9z"></path></svg> Air Conditioning
        @endif
        @if($Hotel->parking == 1)
        <svg class="bk-icon -iconset-parking_sign hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M70.8 44H58v16h12.8a8 8 0 0 0 0-16z"></path><path d="M108 8H20A12 12 0 0 0 8 20v88a12 12 0 0 0 12 12h88a12 12 0 0 0 12-12V20a12 12 0 0 0-12-12zM70 76H58v24H42V28h28a24 24 0 0 1 0 48z"></path></svg> Parking
        @endif
        @if($Hotel->family_rooms == 1)
        <svg class="bk-icon -iconset-family hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M18 18a10 10 0 1 1 10 10 10 10 0 0 1-10-10zm26 16s-9.8-2-16-2-16 2-16 2c-4 1-4.3 3.4-4 6l3.4 30.5a4.3 4.3 0 0 0 1.3 2.6l1.8 1.8a4.3 4.3 0 0 1 1.3 2.7l3.6 38.4a4.4 4.4 0 0 0 4.5 4h8.2a4.4 4.4 0 0 0 4.5-4L40 77.6a4.3 4.3 0 0 1 1.3-2.7l1.9-1.8a4.3 4.3 0 0 0 1.2-2.6L48 40c.3-2.6.1-5-3.9-6zm20 23a8 8 0 1 0-8-8 8 8 0 0 0 8 8zm11.2 2.4A73.6 73.6 0 0 0 64 58a73.6 73.6 0 0 0-11.2 1.4c-2.8.7-3 2.3-2.7 4.1l2.3 21a3 3 0 0 0 1 1.9l1.2 1.2a3 3 0 0 1 1 2l2.4 27.7a3.1 3.1 0 0 0 3.1 2.7H67a3.1 3.1 0 0 0 3.1-2.8l2.5-27.7a3 3 0 0 1 1-1.9l1.2-1.2a3 3 0 0 0 .9-1.8l2.4-21c.2-1.9 0-3.5-2.8-4.2zM100 28a10 10 0 1 0-10-10 10 10 0 0 0 10 10zm16 6s-9.8-2-16-2-16 2-16 2c-4 1-4.3 3.4-4 6l3.4 30.5a4.3 4.3 0 0 0 1.3 2.6l1.8 1.8a4.3 4.3 0 0 1 1.3 2.7l3.6 38.4a4.4 4.4 0 0 0 4.5 4h8.2a4.4 4.4 0 0 0 4.4-4l3.6-38.4a4.3 4.3 0 0 1 1.3-2.7l1.8-1.8a4.3 4.3 0 0 0 1.3-2.6L120 40c.3-2.6.1-5-3.9-6z"></path></svg> Family rooms
        @endif
        @if($Hotel->fitness_centre == 1)
        <svg class="bk-icon -iconset-fitness hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M80 85.6L42.4 48l5.6-5.6L85.6 80zM13.2 19a4 4 0 1 0 5.7-5.7l-4-4A4 4 0 0 0 9.2 15zM56 8l-8 8-8-8L8 40l8 8-8 8 8.1 8.1 48-48zm58.9 101.1a4 4 0 1 0-5.7 5.7l4 4a4 4 0 1 0 5.7-5.7zm5.2-37l-8.1-8.2-48 48 8.2 8.1 8-8 8 8 32-32-8-8z"></path></svg> Fitness Centre<br />
        @endif
        @if($Hotel->spa_and_wellness_centre == 1)
        <svg class="bk-icon -iconset-spa hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M64.7 12.3a.8.8 0 0 0-1 0C57 18 38.4 37.8 59.2 59c.3.3 1.5 1.2 1.7-.3a.6.6 0 0 1 0-.1l3.2-21 3.2 20.8v.3c.3 1.3 1.2.7 1.6.4 21-21.1 2.5-40.8-4.2-46.8zM120 51.8v-.1a.8.8 0 0 0-.3-1C111.9 46.4 87 35.3 74.2 62c-.1.4-.6 1.8.9 1.5l20.8-4-18.4 10-.3.1c-1.2.7-.2 1.4.2 1.6C104.1 84 116.5 60 119.9 51.7zm-111.8.1a.8.8 0 0 1 .3-1c7.7-4.4 32.5-15.4 45.4 11.4.1.3.6 1.7-.9 1.5l-20.9-4 18.5 10h.2c1.2.7.3 1.4-.1 1.7C23.9 84.3 11.5 60.3 8 51.9zm94.5 64a.8.8 0 0 0 .8-.7c.8-8.8.7-36-28.9-36.9-.4 0-1.8.2-1 1.4l12.1 17.5-16.5-12.8-.2-.2c-1.2-.8-1.4.3-1.5.8-.7 29.7 26.2 31.3 35.2 31zm-77.1 0h-.1a.8.8 0 0 1-.8-.7c-.7-8.8-.7-36 29-36.9.3 0 1.8.2 1 1.4L42.3 97.3 59 84.4l.2-.2c1.1-.8 1.4.3 1.4.8.7 29.7-26.2 31.3-35.1 31z"></path></svg> Spa and Wellness Centre
        @endif
        @if($Hotel->swimming_pool == 1)
        <svg class="bk-icon -iconset-pool hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M8.7 79.2a3.8 3.8 0 0 1 5.5-1.3c21 15 34.5 9 50 2.2 14.5-6.5 30.8-13.7 53.6-1.4a4.5 4.5 0 0 1 1.8 5.9 3.9 3.9 0 0 1-5.4 2c-19.5-10.7-32.8-4.8-47 1.5-8.7 3.9-17.6 7.9-28 7.9A50 50 0 0 1 9.9 85.2a4.6 4.6 0 0 1-1.2-6zm109 15.5c-22.7-12.4-39-5-53.5 1.4-15.5 6.9-29 12.9-50-2.2a3.8 3.8 0 0 0-5.6 1.3 4.6 4.6 0 0 0 1.2 6A50 50 0 0 0 39.3 112c10.3 0 19.2-4 28-7.9 14-6.3 27.4-12.2 46.9-1.6a3.9 3.9 0 0 0 5.4-2 4.5 4.5 0 0 0-1.8-5.8zM100 56a12 12 0 1 0-12-12 12 12 0 0 0 12 12zM64.2 72c7.2-3.3 15.2-7 23.8-8.2 0 0-4-8.8-6.8-13.9l-18-29.2c-2.5-4.3-7.5-6-13.5-3.6L27.9 26a6.2 6.2 0 0 0-3.5 7.8 6 6 0 0 0 8 3.4L50 29.7a4 4 0 0 1 5 1.7l6 13.2L24 72c17.6 9.8 26.3 6.3 40.3 0z"></path></svg> Swimming Pool
        @endif
        @if($Hotel->bar == 1)
        <svg class="bk-icon -iconset-bar hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><rect x="60" y="74" width="8" height="44"></rect><rect x="60" y="94" width="8" height="40" rx="4" ry="4" transform="rotate(-90 64 114)"></rect><path d="M100 34H28a4 4 0 0 0-3.2 6.4l36 48a4 4 0 0 0 6.4 0l36-48A4 4 0 0 0 100 34zM78.7 61.7H49.3l-16-21.2h61.4z"></path><rect x="75.5" y="-1.4" width="6" height="81.9" rx="3" ry="3" transform="rotate(36.31 78.487 39.584)"></rect><circle cx="90.6" cy="21.9" r="8"></circle></svg> Bar
        @endif
        @if($Hotel->outdoor_pool == 1)
        <svg class="bk-icon -iconset-pool hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M8.7 79.2a3.8 3.8 0 0 1 5.5-1.3c21 15 34.5 9 50 2.2 14.5-6.5 30.8-13.7 53.6-1.4a4.5 4.5 0 0 1 1.8 5.9 3.9 3.9 0 0 1-5.4 2c-19.5-10.7-32.8-4.8-47 1.5-8.7 3.9-17.6 7.9-28 7.9A50 50 0 0 1 9.9 85.2a4.6 4.6 0 0 1-1.2-6zm109 15.5c-22.7-12.4-39-5-53.5 1.4-15.5 6.9-29 12.9-50-2.2a3.8 3.8 0 0 0-5.6 1.3 4.6 4.6 0 0 0 1.2 6A50 50 0 0 0 39.3 112c10.3 0 19.2-4 28-7.9 14-6.3 27.4-12.2 46.9-1.6a3.9 3.9 0 0 0 5.4-2 4.5 4.5 0 0 0-1.8-5.8zM100 56a12 12 0 1 0-12-12 12 12 0 0 0 12 12zM64.2 72c7.2-3.3 15.2-7 23.8-8.2 0 0-4-8.8-6.8-13.9l-18-29.2c-2.5-4.3-7.5-6-13.5-3.6L27.9 26a6.2 6.2 0 0 0-3.5 7.8 6 6 0 0 0 8 3.4L50 29.7a4 4 0 0 1 5 1.7l6 13.2L24 72c17.6 9.8 26.3 6.3 40.3 0z"></path></svg> Outdoor Pool<br />
        @endif
        @if($Hotel->room_service == 1)
        <svg class="bk-icon -iconset-gourmet hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M112 68a4 4 0 0 1-4 4H20a4 4 0 0 1 0-8h88a4 4 0 0 1 4 4zM26 56h76a2 2 0 0 0 2-2.1 40 40 0 0 0-32-37.1V16a8 8 0 0 0-16 0v.8a40 40 0 0 0-32 37 2 2 0 0 0 2 2.2zm77 24s-27 6-42.7 0C53.6 80 42 83 36 88s-20 15.5-20 15.5L32 120l19.8-19a12 12 0 0 1 8.5-3.5L81.7 96a4 4 0 0 0 2.4-.8l20.1-11.6A2 2 0 0 0 103 80z"></path></svg> Room Service
        @endif
        @if($Hotel->heating == 1)
        <svg class="bk-icon -iconset-heater hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M34.8 19.7a4 4 0 0 1 0-4.8l4-5.3a4 4 0 1 1 6.4 4.8l-2.2 3 2.2 2.9a4 4 0 0 1 0 4.8l-4 5.3a4 4 0 1 1-6.4-4.8l2.2-3zm26.2 3l-2.2 2.9a4 4 0 0 0 6.4 4.8l4-5.3a4 4 0 0 0 0-4.8l-2.2-3 2.2-2.9a4 4 0 1 0-6.4-4.8l-4 5.3a4 4 0 0 0 0 4.8zm24 0l-2.2 2.9a4 4 0 0 0 6.4 4.8l4-5.3a4 4 0 0 0 0-4.8l-2.2-3 2.2-2.9a4 4 0 1 0-6.4-4.8l-4 5.3a4 4 0 0 0 0 4.8zm35 28.5V108a12 12 0 0 1-23.3 4h-9.4a12 12 0 0 1-22.6 0h-9.4a12 12 0 0 1-22.6 0H24v8H8v-8h8V47H8v-8h16v8.2h8.7a12 12 0 0 1 22.6 0h9.4a12 12 0 0 1 22.6 0h9.4a12 12 0 0 1 23.3 4zm-32 4V104h8V55.2zm-32 0V104h8V55.2zM24 104h8V55.2h-8zm24-52.8a4 4 0 1 0-8 0V108a4 4 0 0 0 8 0zM80 108V51.2a4 4 0 1 0-8 0V108a4 4 0 0 0 8 0zm32-56.8a4 4 0 1 0-8 0V108a4 4 0 0 0 8 0z"></path></svg> Heating
        @endif
        @if($Hotel->terrace == 1)
        <svg class="bk-icon -iconset-resort hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M84 116a4 4 0 0 1-4 4H48a4 4 0 0 1 0-8h12V52a4 4 0 0 1 8 0v60h12a4 4 0 0 1 4 4zm-36-16a4 4 0 0 0-4-4H22.9l-7.1-21.3a4 4 0 1 0-7.6 2.6l7.5 22.4-7.3 14.5a4 4 0 1 0 7.2 3.6l6.9-13.8H32v12a4 4 0 0 0 8 0v-12h4a4 4 0 0 0 4-4zm64.3-.3l7.5-22.4a4 4 0 0 0-7.6-2.6l-7 21.3H84a4 4 0 0 0 0 8h4v12a4 4 0 0 0 8 0v-12h9.5l7 13.8a4 4 0 0 0 7-3.6zM12.3 40h103.4c3.7 0 5.7-4.1 3.2-6.7C109.8 24 90.4 8 64 8S18.2 24 9.1 33.3C6.6 36 8.6 40 12.3 40z"></path></svg> Terrace
        @endif
        @if($Hotel->garden == 1)
        <svg class="bk-icon -iconset-garden hp__important_facility_icon" height="20" width="20" viewBox="0 0 128 128"><path d="M116 112H69V80.7a10.5 10.5 0 0 0 5.5-9.2 8.5 8.5 0 0 0-.2-1.7 8.5 8.5 0 0 0 1 1.4 10.5 10.5 0 0 0 14.9-14.9 8.5 8.5 0 0 0-1.4-1 8.5 8.5 0 0 0 1.7.2 10.5 10.5 0 0 0 0-21 8.5 8.5 0 0 0-1.7.2 8.5 8.5 0 0 0 1.4-1 10.5 10.5 0 1 0-14.9-14.9 8.5 8.5 0 0 0-1 1.4 8.5 8.5 0 0 0 .2-1.7 10.5 10.5 0 1 0-21 0 8.5 8.5 0 0 0 .2 1.7 8.5 8.5 0 0 0-1-1.4 10.5 10.5 0 0 0-14.9 14.9 8.5 8.5 0 0 0 1.4 1 8.5 8.5 0 0 0-1.7-.2 10.5 10.5 0 0 0 0 21 8.5 8.5 0 0 0 1.7-.2 8.5 8.5 0 0 0-1.4 1 10.5 10.5 0 0 0 14.9 14.9 8.5 8.5 0 0 0 1-1.4 8.5 8.5 0 0 0-.2 1.7 10.5 10.5 0 0 0 5.5 9.2V112H12a4 4 0 0 0 0 8h104a4 4 0 0 0 0-8zM87.3 68.3a6.5 6.5 0 0 1-9.1 0 42 42 0 0 1-5.1-12 15.6 15.6 0 0 0 2.4-2.2 42.2 42.2 0 0 1 11.8 5 6.5 6.5 0 0 1 0 9.2zM97 45a6.5 6.5 0 0 1-6.5 6.5c-2 0-6.7-2.1-11.3-4.5a15.6 15.6 0 0 0 .4-3.3v-.9c4.4-2.3 9-4.3 11-4.3A6.5 6.5 0 0 1 97 45zM78.2 21.7a6.5 6.5 0 0 1 9.1 9.1 37 37 0 0 1-10.2 4.6 15.6 15.6 0 0 0-3.3-3.8c1.4-4.5 3.1-8.7 4.4-10zM64 12a6.5 6.5 0 0 1 6.5 6.5c0 1.7-1.7 5.8-3.8 9.9a14.7 14.7 0 0 0-5.4 0 35 35 0 0 1-3.8-10A6.5 6.5 0 0 1 64 12zm-23.3 9.7a6.5 6.5 0 0 1 9.1 0 32 32 0 0 1 4.5 9.9 15.6 15.6 0 0 0-3.4 3.8 35 35 0 0 1-10.2-4.6 6.5 6.5 0 0 1 0-9.1zM31 45a6.5 6.5 0 0 1 6.5-6.5c1.9 0 6.5 2 11 4.3v1a15.6 15.6 0 0 0 .3 3.2 38.8 38.8 0 0 1-11.3 4.5A6.5 6.5 0 0 1 31 45zm18.8 23.3a6.5 6.5 0 0 1-9.1-9.1c1.4-1.5 6.7-3.5 11.8-5a15.6 15.6 0 0 0 2.4 2.1 42.1 42.1 0 0 1-5 12zm12.7-9.1h3c2.5 4.8 5 10.2 5 12.3a6.5 6.5 0 0 1-13 0c0-2 2.5-7.4 5-12.3zM48 104q-24 0-24-24 24 0 24 24zm56-24q0 24-24 24 0-24 24-24z"></path></svg> Garden
        @endif
    </div>
</div>
@endif
</div>
@endsection