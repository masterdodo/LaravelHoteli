@extends('layouts.app')
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h1>New User</h1>

{!! Form::open(['method'=>'POST', 'action'=>'UserController@store']) !!}
<div class="form-group">
    {!! Form::label('name', 'User name:(min 5 chars)') !!}
    {!! Form::text('name', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('email', 'User email:') !!}
    {!! Form::text('email', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('password', 'Password:(min 6 chars)') !!}
    {!! Form::text('password', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('password_confirmation', 'Password confirmation:') !!}
    {!! Form::text('password_confirmation', null, ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('editor', 'Editor:') !!}
    {!! Form::checkbox('editor', 1, ['class'=>'form-control']) !!}
</div>
<div class="form-group submit-new-hotel">
    {!! Form::submit('Create user', ['class'=>'btn']) !!}
</div>
{!! Form::close() !!}

@endsection