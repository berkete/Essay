@extends('layouts.app')

@section('content')

    <h1>The calculation page</h1>

   @if($customers)
    @foreach($customers as $customer)

        <ul>


            <li>{{$customer}}</li>
        </ul>


        @endforeach

    @endif
    @endsection