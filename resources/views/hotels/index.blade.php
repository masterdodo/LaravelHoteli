@extends('layouts.app')
@section('content')
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif
@if(Auth::user())
@if(Auth::user()->id == 3 || Auth::user()->editor == 1)
<a href="{{ action('HotelsController@create') }}" class="standard-btn">New Hotel</a>
@endif
@if(Auth::user()->id == 3)
<a href="{{ action('UserController@index') }}" class="standard-btn">Users</a><br /><br />
@elseif(Auth::user()->editor == 1)
<br /><br />
@endif
@endif
<div id="index-banner">
    <p id="banner-title">Find the best hotel for you.</p>
    {!! Form::open(array('action' => 'QueryController@search', 'id'=>'banner-search-form')) !!}
        {!! Form::text('search', null,
                           array('required',
                                'id'=>'search-input',
                                'placeholder'=>'Search for a hotel...')) !!}
        {!! Form::submit('Search',
                                array('id'=>'search-submit')) !!}
    {!! Form::close() !!}
</div><br />
<div id="hotels">
@foreach($AllHotels as $Hotel)
    <div class="hotel-index-div">
        <div class="hotel-index-div-left">
            <img src="{{url('/images'). "/" . $Hotel->image}}" alt="hotel_image" class="hotel-image">
            <p><b>{{$Hotel->name}}</b> - <span class="price-hotel"><b>{{$Hotel->price}} €</b></span></p>
        </div>
        <div class="hotel-index-div-right">
            <p><b>Published by:</b>
            @foreach($AllUsers as $User)
                @if($User->id == $Hotel->user_id)
                    {{ $User->name . ',' }}
                @endif
            @endforeach
            {{ $Hotel->created_at->diffForHumans() }}</p>
            <p><b>Filled:</b> {{$Hotel->filled_places}}/{{$Hotel->all_places}} <b>Free places:</b> {{$Hotel->all_places - $Hotel->filled_places}} </p>
            <p><b>Hotel address:</b> {{$Hotel->address}}</p>
            <p><b>First day of accommodation:</b> {{$start_date = date('d. m. Y', strtotime($Hotel->start_date))}}</p>
            <p><b>Last day of accommodation:</b> {{$end_date = date('d. m. Y', strtotime($Hotel->end_date))}}</p>
            <p><b>Hotel description:</b><br /> {{$Hotel->description}}</p>
            @if(Auth::user())
            <tr>
                @if(Auth::user()->id != 3)
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
                        <label for="capacity">Number of people to login:</label>
                        <input type="number" min="1" max="{{ $Hotel->all_places }}" name="capacity" id="capacity-field"><button class="link-to-button green-button" type="submit">Log In</button>
                    </form>
                </td>
                @endif
                @php $_SESSION['logout_exists'] = 0 @endphp
                @endif
                <table>
                @if(Auth::user()->id == $Hotel->user_id || Auth::user()->id == 3)
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