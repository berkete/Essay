@extends('layouts.app')

@section('content')
   @if($customers)
       <form action="/searchs" method="post">
           {{ csrf_field() }}
       <div class="row">
           <div class="col-sm-2">
               <select name="o" id="o">
                   @foreach($customers as $customer)
                       <option name="o" value="{{$customer->card_holder}}">{{$customer->card_holder}}</option>
                   @endforeach
               </select>

           </div>
           <div class="col-sm-2">
               <lable>
                   Name
               </lable>
               <select name="p" id="p">
                   @foreach($customers as $customer)
                       <option name="p" value="{{$customer->card_number}}">{{$customer->card_number}}</option>
                   @endforeach

               </select>

           </div>

           <div class="col-sm-2">


               <select name="w" id="w">
                   @foreach($customers as $customer)
                       <option  name="w" value="{{$customer->created_at}}">{{$customer->created_at}}</option>
                   @endforeach
               </select>
           </div>
            <div class="col-sm-2">　
                <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>

            </div>
       </div>






       </form>
       @endif


    <h1>Search page</h1>
@endsection