@extends('layouts.app')

@section('content')
  @if(isset($details))

      <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Card number</th>
              <th>Date</th>
            </tr>
          </thead>




      @foreach($details  as $customer)

              <tr class="info">
              <td>{{$customer->card_holder}}</td>
              <td>{{$customer->card_number}}</td>
              <td>{{$customer->created_at}}</td>
              </tr>


          @endforeach
      </table>


      @endif

    <h1>Search page</h1>
    @endsection