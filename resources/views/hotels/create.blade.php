@extends('layouts.app')

@section('content')

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

<h1>New Hotel</h1>
<br />

    <div class="create-hotel-div">
        {!! Form::open(['method'=>'POST', 'action'=>'HotelsController@store', 'enctype'=>'multipart/form-data']) !!}
        {!! Form::hidden('user_id', $id = Auth::id()) !!}
        <div class="form-group">
            {!! Form::label('name', 'Hotel name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('address', 'Hotel address:') !!}
            {!! Form::text('address', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
                {!! Form::label('price', 'Price:(in euros)') !!}
                {!! Form::text('price', null, ['class'=>'form-control']) !!}
            </div>

        <div class="form-group">
            {!! Form::label('all_places', 'Available places:') !!}
            {!! Form::text('all_places', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('start_date', 'Start date:') !!}
            {!! Form::date('start_date', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('end_date', 'End date:') !!}
            {!! Form::date('end_date', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('image', 'Image:') !!}
            {!! Form::file('image', ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Description:') !!}
            {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group submit-new-hotel">
            {!! Form::submit('Create hotel', ['class'=>'btn']) !!}
        </div>

        {!! Form::close() !!}
    </div>

@endsection