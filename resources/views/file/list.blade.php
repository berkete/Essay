@extends('layouts.app')
@section('content')

    <h1>file list</h1>

    @if(Session::has('delete_media'))
        <p class="bg-danger pull-right" >{{session('delete_media')}}</p>
        @endif
    @if($files)
        <h1></h1>
@if(Session::has('download_media'))
    <p class="bg-success pull-right" >{{session('download_media')}}</p>

@endif

        <table class="table">
            <thead>
            <tr class="danger">
                <th>Click to Download</th>
                <th>File Size</th>
                <th>Uploaded Date</th>
                <th>File Type</th>

                <th>Delete</th>

            </tr>
            </thead>
            @foreach(scandir($files, 1) as $key=>$value)
                {{--@foreach($files as $file)--}}
                @if(!($value==".DS_Store"||$value=='..'||$value=='.'))
                    <tbody>
                    <tr class="success">
                        <td><a href="/getDownload/{{$value}}" class="btn btn-large pull-left"><i class="fa fa-download"></i>{{$value}}</a></td>
                        {{--{{$size[]=filesize($file)}}--}}
                        <td><a href="#"></a>{{(floor(filesize($files.'/'.$value)/1024)."KB")}}</td>
                        <td><a href="#"></a>{{date_default_timezone_set('Asia/Tokyo').date('jS F Y h:i:s A',filectime($files.'/'.$value))}}</td>
                        <td><a href="#"></a>{{mime_content_type($files.'/'.$value)}}</td>

                        <td><a href="getDeletes/{{$value}}"  class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i>Delete</a></td>
                    </tr>
                    @endif
                    {{--@endforeach--}}
                    @endforeach
                    </tbody>
        </table>
    @endif

@endsection