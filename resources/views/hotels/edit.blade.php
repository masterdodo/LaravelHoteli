@extends('layouts.app')

@section('content')

<h1>Edit hotel</h1>
<br />

    <div class="edit-hotel-div">
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
                    <label for="price">Price:</label>
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
                <label for="image">Image:</label>
                <input type="file" class="form-control" name="image">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description">
                    {{$hotel->description}}
                </textarea>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-success" style="margin-left:38px">Edit hotel</button>
            </div>
        </form>
    </div>
    </div>


@endsection