@extends('layouts.app')

@section('content')
@if(Auth::user()->id != $user->id)
    {{ exit() }}
@endif

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="post" action="{{ action('UserController@update', $user->id) }}">
    {{ csrf_field() }}
    {{ method_field('patch') }}

    <div class="form-group">
        <label for="name">Username:(min 5 chars)</label>
        <input type="text" class="form-control" name="name"  value="{{ $user->name }}">
    </div>
    <div class="form-group">
        <label for="password">Password:(min 6 chars)</label>
        <input type="password" class="form-control" name="password">
    </div>
    <div class="form-group">
        <label for="password_confirmation">Confirm password:</label>
        <input type="password" class="form-control" name="password_confirmation">
    </div>
    <div class="row">
            <button type="submit" class="btn btn-success" style="margin-left:38px">Edit profile</button>
        </div>
</form>
@endsection