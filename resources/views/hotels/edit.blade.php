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

<h1 class="margin">Edit hotel</h1>
<br />

    <div class="edit-hotel-div margin">
        <form method="post" action="{{action('HotelsController@update', $id)}}" enctype="multipart/form-data">
            @csrf
            <input name="_method" type="hidden" value="PATCH">
            <div class="form-group">
                <label for="name">Hotel name:</label>
                <input type="text" class="form-control" name="name" value="{{$hotel->name}}">
            </div>
            <div class="form-group">
                <label for="address">Hotel address:</label>
                <input type="text" class="form-control" name="address" value="{{$hotel->address}}">
            </div>
            <div class="form-group">
                    <label for="price">Price:(in euros)</label>
                    <input type="number" class="form-control" name="price" value="{{$hotel->price}}">
                </div>
            <div class="form-group">
                <label for="all_places">Available places:</label>
                <input type="number" class="form-control" name="all_places" value="{{$hotel->all_places}}">
            </div>
            <div class="form-group">
                <label for="start_date">Start date:</label>
                <input type="date" class="form-control" name="start_date" value="{{$start_date = date('Y-m-d', strtotime($hotel->start_date))}}">
            </div>
            <div class="form-group">
                <label for="end_date">End date:</label>
                <input type="date" class="form-control" name="end_date" value="{{$end_date = date('Y-m-d', strtotime($hotel->end_date))}}">
            </div>
            <div class="form-group">
                {!! Form::label('image', 'Image:') !!}
                {!! Form::file('image', ['class'=>'form-control-file']) !!}
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description">{{$hotel->description}}</textarea>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-success" style="margin-left:15px">Edit hotel</button>
            </div>
        </form>
    </div>
    </div>


@endsection
