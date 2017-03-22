
@extends('layouts.app')
@section('title','Welcome')

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <marquee behavior="alternate" direction="left">Welcome to Entry Report Page</marquee>

        </div>
    </div>
    <div class="col-sm-8">


    </div>

    <script type="http://cdn.jsdelivr.net/jquery.marquee/1.3.1/jquery.marquee.min.js"></script>
    <div class="row" style="margin-top: 70px;">
        <p>Total number of records in the database<i style="color: rgba(47, 49, 255, 0.68);padding-left: 10em">{!!\App\Customer::count() !!}</i> </p>
        <hr>
        @if($path)
            <p>Total number of files in public directory<i style="color: rgba(47, 49, 255, 0.68);padding-left: 10em">  {{count($path)}}</i> </p>
            @endif
        <hr>
    </div>

@endsection