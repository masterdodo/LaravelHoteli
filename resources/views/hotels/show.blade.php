@extends('layouts.app')

@section('content')

<h2>Logged user</h2>
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
                    <form action="{{ action('HotelsController@hotellogout') }}">
                        <input type="hidden" name="user_id" value="{{ $Loged_user->id }}">
                        <input type="hidden" name="hotel_id" value="{{ $Hotel->id }}">
                        <button class="link-to-button red-button" type="submit">Log Out</button>
                    </form>
                </td>
            @endif
        @endforeach
    </tr>
@endforeach
</table>
@endsection