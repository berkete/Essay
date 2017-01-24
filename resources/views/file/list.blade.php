@extends('layouts.app')
@section('content')

    <h1>file list</h1>
    @if($files)
<h1></h1>


<table class="table">
            <thead>
              <tr>
                <th>Click to Download</th>
                <th>Lastname</th>
                <th>Email</th>
              </tr>
            </thead>
            @foreach(scandir($files, 1) as $key=>$value)
            {{--@foreach($files as $file)--}}
            @if(!($value==".DS_Store"||$value=='..'||$value=='.'))
            <tbody>
              <tr class="success">
                <td><a href="/getDownload/{{$value}}">{{$value}}</a></td>
                {{--{{$size[]=filesize($file)}}--}}
                 <td><a href="getDeletes/{{$value}}">Remove</a></td>
                  <td><a href="/getDeletes/{{$value}}">Delete</a>{{$value}}</td>
              </tr>
              @endif
            {{--@endforeach--}}


        @endforeach
            </tbody>
        </table>
    @endif

    @endsection