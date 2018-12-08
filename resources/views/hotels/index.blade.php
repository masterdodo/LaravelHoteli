@extends('layouts.app')
@section('content')
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
@if(Auth::user())
<a href="{{ action('HotelsController@create') }}" class="standard-btn">New Hotel</a><br /><br />
@endif
<div id="index-banner">
    <p id="banner-title">Find the best hotel for you.</p>
    <form id="banner-search-form" action="{{ action('HotelsController@search') }}" method="post">
        <input id="search-input" type="text" name="search" placeholder="Search for a hotel..."><button id="search-submit" type="submit">Search</button>
    </form>
</div><br />
<div id="hotels">
@foreach($AllHotels as $Hotel)
    <div class="hotel-index-div">
        <div class="hotel-index-div-left">
            <img src="{{url('/images'). "/" . $Hotel->image}}" alt="hotel_image" width="380">
            <p><b>{{$Hotel->name}}</b> - <span class="price-hotel"><b>{{$Hotel->price}} €</b></span></p>
        </div>
        <div class="hotel-index-div-right">
            <p><b>Availability:</b> {{$Hotel->filled_places}}/{{$Hotel->all_places}}</p>
            <p><b>Hotel address:</b> {{$Hotel->address}}</p>
            <p><b>First day of accommodation:</b> {{$start_date = date('d. m. Y', strtotime($Hotel->start_date))}}</p>
            <p><b>Last day of accommodation:</b> {{$end_date = date('d. m. Y', strtotime($Hotel->end_date))}}</p>
            <p><b>Hotel description:</b><br /> {{$Hotel->description}}</p>
            @if(Auth::user())
            <table>
            <tr>
                @php $_SESSION['logout_exists'] = 0 @endphp
                @if(isset($Logins))
                @foreach($Logins as $login)
                @if($login->hotel_id == $Hotel->id)
                @php $_SESSION['logout_exists'] = 1 @endphp
                <td>
                    <form action="{{ action('HotelsController@hotellogout') }}">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="hotel_id" value="{{ $Hotel->id }}">
                        <button class="link-to-button red-button" type="submit">Log Out</button>
                    </form>
                </td>
                @endif
                @endforeach
                @endif
                @if($Hotel->filled_places < $Hotel->all_places && $_SESSION['logout_exists'] != 1)
                <td>
                    <form action="{{ action('HotelsController@hotellogin') }}">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="hotel_id" value="{{ $Hotel->id }}">
                        <button class="link-to-button green-button" type="submit">Log In</button>
                    </form>
                </td>
                @endif
                @php $_SESSION['logout_exists'] = 0 @endphp
                @if(Auth::user()->id == $Hotel->user_id)
                <td>
                    <form action="{{ action('HotelsController@edit', ['id' => $Hotel->id]) }}">
                        <button class="link-to-button yellow-button" type="submit">Edit Hotel</button>
                    </form>
                </td>
                <td>
                    {!! Form::open(['action' => ['HotelsController@destroy', $Hotel->id] ]) !!}
                        {{ Form::hidden('_method', 'delete') }}
                        {{ Form::submit('Delete Hotel',['class' => 'link-to-button red-button', 'onclick' => 'return  confirm(\'Are you sure you want to delete this hotel?\')'])}}
                    {!! Form::close() !!}
                </td>
                @endif
            </tr>
            </table>
            @else
            <table>
                <tr>
                        <a class="link-to-button green-button" href="{{ url('/login') }}">Log In</a>
                </tr>
            </table>
            @endif
        </div>
        <div class="hotel-index-div-end-float"></div>
    </div>
@endforeach
</div>

@endsection