@extends('layouts.app')

@section('content')
   @if($customers)
       <form action="/searchs" method="post">
           {{ csrf_field() }}
           <div class="row" style="color:cornflowerblue;text-decoration: blink;font-size: large;margin-top: 100px">
               <div class="col-sm-3">年</div>
               <div class="col-sm-3">月</div>
               <div class="col-sm-3">名前</div>
           </div>
       <div class="row" style="color: dodgerblue">
           <div class="col-sm-3">
               <label for="Year"></label>
               <select name="w" id="w" class="form-control color panel-red">
                   @foreach($customers as $customer)
                       <option  name="w" value="{{$customer->created_at}}">{{\Carbon\Carbon::parse($customer->created_at)->format('Y')}}</option>
                   @endforeach
               </select>



           </div>

           <div class="col-sm-3">
               <label for="Month"></label>

               <select name="p" id="p" class="form-control">
                   @foreach($customers as $customer)
                       <option name="p" value="{{$customer->card_number}}">{{\Carbon\Carbon::parse($customer->created_at)->format('m')}}</option>
                   @endforeach

               </select>

           </div>

           <div class="col-sm-3">
               <label for="Name"></label>

               <select name="o" id="o" class="form-control">
                   @foreach($customers as $customer)
                       <option name="o" value="{{$customer->card_holder}}">{{$customer->card_holder}}</option>
                   @endforeach
               </select>


           </div>
            <div class="col-sm-3" style="    margin-top: 1px;">　
                <span class="input-group-btn">
                <button type="submit" class="btn btn-default" value="Search">Search
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>

            </div>
       </div>






       </form>



   @endif


@endsection