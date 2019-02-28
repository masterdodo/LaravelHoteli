@extends('layouts.app')
@section('content')

@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<a href="{{ action('UserController@create') }}" class="standard-btn">Add User</a><br /><br />
<div style="overflow: auto;">
<table border="1" class="table">
<thead>
    <th>User name</th>
    <th>User email</th>
    <th>Editor</th>
    <th>Created</th>
    <th>Remove</th>
</thead>
@foreach($AllUsers as $User)
@if($User->name == 'admin' && $User->id == 3)
@else
<tr>
    <td>{{ $User->name }}</td>
    <td>{{ $User->email }}</td>
    <td>
    @if($User->editor == 1)
    {{ 'Is Editor.' }}
    @else
    {{ 'Is not editor.' }}
    @endif
    </td>
    <td>{{ $User->created_at->diffForHumans() }}</td>
    <td>
        {!! Form::open(['action' => ['UserController@destroy', $User->id] ]) !!}
            {{ Form::hidden('_method', 'delete') }}
            {{ Form::submit('Delete User',['class' => 'link-to-button red-button', 'onclick' => 'return  confirm(\'Are you sure you want to remove this user?\')'])}}
        {!! Form::close() !!}
    </td>
</tr>
@endif
@endforeach
</table>
</div>

@endsection