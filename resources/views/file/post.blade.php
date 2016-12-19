@extends('layouts.app')


@section('content')


    <h1>works</h1>
    @if($posts)

        @foreach($posts as $post)

            <table class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>In</th>
                    <th>out</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="success">
                    <td>{{$post->name}}</td>

                    <td>{{$post->created_at}}</td>
                    <td>john@example.com</td>
                  </tr>
                </tbody>
              </table>

            @endforeach

    @endif

    @endsection