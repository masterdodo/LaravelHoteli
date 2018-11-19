@extends('layouts.app')

@section('content')

<h1>Contact Us</h1>
<br />

    <div class="create-hotel-div">
        {!! Form::open(['method'=>'POST', 'action'=>'HotelsController@store']) !!}
        <!-- @ csfr omogoča, da ko pošlemo prazno formo, ostanemo na insti strani in ne napiše
        error page not found -->

        <div class="form-group">
            {!! Form::label('name', 'Hotel name:') !!}
            {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('address', 'Hotel address:') !!}
            {!! Form::text('address', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('filled_places', 'Filled places:') !!}
            {!! Form::numbers('filled_places', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('all_places', 'All places:') !!}
            {!! Form::numbers('all_places', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('start_date', 'Start date:') !!}
            {!! Form::text('start_date', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('end_date', 'End date:') !!}
            {!! Form::text('end_date', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('image', 'Image:') !!}
            {!! Form::text('image', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Description:') !!}
            {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
        </div>

        <div class="form-group submit-contact-form">
            {!! Form::submit('Send email', ['class'=>'btn']) !!}
        </div>

        {!! Form::close() !!}
    </div>

@endsection