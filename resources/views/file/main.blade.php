@extends('layouts.app')


@section('content')


   {{--{!! Form::open(['method'=>'POST','action'=>'AdminController@getCalculation']) !!}--}}
       {{--<div class="form-group">--}}
           {{--{!! Form::label('title','Title:') !!}--}}
           {{--{!! Form::text('title',null,['class'=>'form-control']) !!}--}}


       {{--</div>--}}
   {{--<div class="row" style="background-color:lightblue">--}}
           {{--<div class="col-sm-4">--}}
               {{--{!! Form::label('year','とし') !!}--}}
               {{--{!! Form::selectYear('year',2016,2030) !!}--}}


           {{--</div>--}}
         {{--<div class="col-sm-4">--}}
             {{--{!! Form::label('month','月') !!}--}}
             {{--{!! Form::selectMonth('months',['class'=>'btn']) !!}--}}

         {{--</div>--}}

       {{--<div class="col-sm-4">--}}
           {{--{!! Form::label('name','生い') !!}--}}
           {{--{!! Form::selectMonth('months') !!}--}}
       {{--</div>--}}


   {{--</div>--}}

       {{--<div class="form-group">--}}

           {{--{!! Form::submit('Create Post',['class'=>'btn btn-primary']) !!}--}}

       {{--</div>--}}
         {{--{!! Form::close() !!}--}}
<hr>


           {!! Form::open(['method'=>'POST','action'=>'AdminController@getCalculation']) !!}
           <div class="form-group">
               {!! Form::label('title','Title:') !!}
               {!! Form::text('title',null,['class'=>'form-control']) !!}


           </div>
           <div class="row" style="background-color:lightblue">


           {{--<div class="form-group">--}}

           {{--{!! Form::submit('Create Post',['class'=>'btn btn-primary']) !!}--}}

           {{--</div>--}}
                   <div class="col-sm-4">
                       {!! Form::label('year','年') !!}
                       {!! Form::selectYear('created_at',2016,2030,null,['class'=>'form-control']) !!}


                   </div>
                   <div class="col-sm-4">
                       {!! Form::label('month','月') !!}
                       {!! Form::select('customer',\App\Customer::groupBy('created_at')->pluck('created_at','id'),null,['class'=>'form-control']) !!}

                   </div>

                   <div class="col-sm-4">
                       {!! Form::label('name','名前') !!}
                       <a href="{{url('#')}}">
                           {!! Form::select('customer1',$x=\App\Customer::groupBy('card_holder')->pluck('card_holder','id'),null,['class'=>'form-control']) !!}
                       </a>

                       {{--@if(!isset($x))--}}
                           {{--<h1>works</h1>--}}
                           {{--@else--}}
                           {{--<h1>not working</h1>--}}
                           {{--@endif--}}


                   </div>
               {{--<div class="col-sm-3">--}}
                   {{--<div class="form-group">--}}
                       {{--{!! Form::Label('card_holder', 'Card_holder:') !!}--}}
                       {{--<select class="form-control" name="card_holder">--}}
                           {{--@foreach($customers as $customer)--}}
                               {{--<option value="{{$customer->card_holder}}">{{$customer->card_holder}}</option>--}}
                           {{--@endforeach--}}
                       {{--</select>--}}
                   {{--</div>--}}

               {{--</div>--}}

               <table class="table" style="background-color: lightskyblue; border: inherit">
                   <thead>
                   <tr>
                       <th>Name</th>
                       <th>Date</th>
                       <th>In</th>
                       <th>Out</th>
                       <th>Enter</th>
                       <th>Leave</th>
                   </tr>
                   </thead>
                   <?php

               if($customers)
                   $x;$y;$sumin=0;$sumout=0;
       foreach($customers as $customer){

            $new_time=explode(" ",$customer->created_at);
             $get_date=$new_time[0];
           $get_time= $new_time[1];
           for($i=0;$i<count($customer);$i++){
            if($customer->status=='入室' && $customer->company=='入側'){
                $x= $customer->created_at[$i]-$customer->created_at[$i+1];
                    $sumin=$sumin+$x;

                  }
            elseif($customer->status=='退室'&&$customer->company=='出側'){
                 $y=$customer->created_at[$i]-$customer->created_at[$i+1];
                 $sumout=$sumout+$y;
               }}
               }
                ?>

                    @if($customers)
                        @foreach($customers as $customer)
                           <tr class="info">
                               <td>{{$customer->card_holder}}</td>
                               <td>{{\Carbon\Carbon::parse($customer->created_at)->format('m/d')}}</td>
                               @if($customer->status=='入室' && $customer->company=='入側')


                                   <td>{{\Carbon\Carbon::parse($customer->created_at)->format('h:m:s')}}</td>
                               @endif
                               @if($customer->status=='退室' && $customer->company=='出側')

                                   <td>{{\Carbon\Carbon::parse($customer->created_at)->format('h:m:s')}}</td>
                               @endif
                               <td>{{$sumin}}</td>
                               <td>{{$sumout}}</td>
                               <td>{{$get_time}}</td>
                               {{--<td>{{$customer->created_at->latest()}}</td>--}}
                               {{--<td>{{\Carbon\Carbon::parse($customer->orderBy('created_at','desc')->format('h:m:s')->first())}}</td>--}}
                               {{--<td>{{$customer->groupBy('created_at')->format('h:m:s')->last()}}</td>--}}
                           </tr>

                            @endforeach


                        @endif


       {{--@endforeach--}}
           {!! Form::close() !!}
               </table>

       </div>

       {{--@endif--}}

   <div id="bottom">


       it works
   </div>

    @endsection

@section('script')
    <script>
        jQuery(document).ready(function($){
            $('#customer').change(function() {
                $.get("{{ url('main')}}",
                    {option: $(this).val()},
                        function (data) {
                    var item = $('#customer1');
                    item.empty();
                    $.each(data, function (key, value) {
                        item.append("<option value='" + value.id + "'>" + value.name + "</option>");
                    });
                });
            });
        });
    </script>
@endsection