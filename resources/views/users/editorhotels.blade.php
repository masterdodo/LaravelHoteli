@extends('layouts.app')

@section('content')
    <h2>All of your hotels</h2>
    <br />
    <div style="overflow:auto;">
    <table class="table">
        <thead class="black white-text">
            <td>#</td>
            <td>Hotel name</td>
            <td>Hotel address</td>
            <td>Filled places</td>
            <td>All places</td>
            <td>Price</td>
        </thead>
        <tbody>
        @php
        $count = 0;
        @endphp
        @foreach ($Hotels as $hotel)
        @php
            $count++;
        @endphp
            <tr>
                <td>{{ $count }}</td>
                <td>{{ $hotel->name }}</td>
                <td>{{ $hotel->address }}</td>
                <td>{{ $hotel->filled_places }}</td>
                <td>{{ $hotel->all_places }}</td>
                <td>{{ $hotel->price }}€</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@endsection