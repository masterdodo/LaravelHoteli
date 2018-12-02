@extends('layouts.app')
@section('content')
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
<a href="{{ action('HotelsController@create') }}" class="standard-btn">New Hotel</a><br /><br />
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
        </div>
        <div class="hotel-index-div-right">
            <p><b>Hotel name:</b> {{$Hotel->name}}</p>
            <p><b>Hotel address:</b> {{$Hotel->address}}</p>
            <p><b>First day of accommodation:</b> {{$start_date = date('d. m. Y', strtotime($Hotel->start_date))}}</p>
            <p><b>Last day of accommodation:</b> {{$end_date = date('d. m. Y', strtotime($Hotel->end_date))}}</p>
            <p><b>Hotel description:</b><br /> {{$Hotel->description}}</p>
            @if(Auth::user())
                @if(Auth::user()->id == $Hotel->user_id)
                <table>
                <tr>
                <td>
                    <a class="link-to-button yellow-button" href="{{ action('HotelsController@edit', ['id' => $Hotel->id]) }}">Edit Hotel</a>
                </td>
                <td>
                    {!! Form::open(['action' => ['HotelsController@destroy', $Hotel->id] ]) !!}
                        {{ Form::hidden('_method', 'delete') }}
                        {{ Form::submit('Delete Hotel',['class' => 'link-to-button red-button'])}}
                    {!! Form::close() !!}
                </td>
                </tr>
                </table>
                @endif
            @endif
        </div>
        <div class="hotel-index-div-end-float"></div>
    </div>
@endforeach
</div>

@endsection