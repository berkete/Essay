<meta name="csrf-token" content="{{ csrf_token() }}">


@extends('layouts.app')


@section('content')

   @if($customer1)
       <form action="/searchs" method="post">
           {{ csrf_field() }}
           <div class="row" style="color:cornflowerblue;text-decoration: blink;font-size: large;margin-top: 100px">
               <div class="col-sm-3">年</div>
               <div class="col-sm-3">月</div>
               <div class="col-sm-3">名前</div>
           </div>
       <div class="row" style="color: dodgerblue">
           <div class="col-sm-3">
               {{--<label for="Year"></label>--}}
               <label for="year"></label>
              {{--{!!  Form::open() !!}--}}
               {{--{!! Form::select("year",$customer1) !!}--}}
               {{--<label for="">名前　</label>--}}
               {{--{{Form::select('customers',[''=>'Select name']+$customer1,null,['class'=>'input-sm'])}}--}}

               {{--{!! Form::close() !!}--}}
               <select name="year" id="year" class="form-control" placeholder="Select">
                   @foreach($customer1 as $customer)
                       <option  name="year"  value="{{$customer->year}}">{{$customer->year}}</option>
                   @endforeach
               </select>
           </div>

        @endif
       @if($customers)

           <div class="col-sm-3">
               {{--<label for="Month"></label>--}}

               <label for="month"></label>
               <select name="month" id="month" class="form-control">
                   @foreach($customers as $customer)
                       {{--<option name="month" value="{{$customer->month}}">{{$customer->month}}</option>--}}
                   @endforeach
               </select>
           </div>
        @endif
           @if($customer2)
           <div class="col-sm-3">
               <label for="name"></label>
               <select name="name" id="name" class="form-control">
                   @foreach($customer2 as $customer)
                       {{--<option name="name" value="{{$customer->card_holder}}">{{$customer->card_holder}}</option>--}}

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

            {{--@for($i=0;$i<count($customer2);$i++)--}}

                {{--{{var_dump(count($customer2))}}--}}
           {{--@if($customer1[$i]==$customer1[$i+1] && $customers[$i]==$customers[$i+1])--}}
               {{--<p> {{$customer2}}</p>--}}



                    {{--@endif--}}


                {{--@endfor--}}




       </form>


       <div class="row">
           <input type="submit" value="click" id="submit">
           <div class="col-sm-6" id="display">thdi</div>


       </div>
       {{--<a href="" class="btn btn-sm btn-info btn-add-more-customers">+year</a>--}}
       {{--<a href="" class="btn btn-sm btn-info btn-add-more-customers2">+Date and Month</a>--}}
       {{--<a href="" class="btn btn-sm btn-info btn-add-more-customers1">+Name</a>--}}


   @endif

   <script type="text/javascript">


       $(document).ready(function () {

           $('#year').change(function (e) {
               e.preventDefault();

               var myData=$('#year');


               $.ajax({
                   type: "get",
                   cache: false,
                   dataType: "json",
                   data: myData,

                   contentType:'charset=UTF-8',
                   url: "ajax-month"
               })
                       .success(function( data ) {
                           console.log("shume:"+data);

//                           $( "#myModal" ).html(data['body']);
//                           $( "#myModalLabel" ).html(data['title']);

//           });
//               $.get('/ajax-month',function (data) {
//                   console.log("shume:"+data);
                   $("#month").empty();
                   $.each(data,function (index,value) {
                       console.log(value.month,index);
                       $("#month").append('<option value=" '+ value.month+'">'+value.month+'</option>');
                   });

               });
           });
       });
//       $(function () {
//
//
//           if("#month") {
//               $('#month').change(function (e) {
//                   console.log(e);
//                   $.get('/ajax-name', function (data) {
//                   console.log(data);
//                       $("#name").empty();
//                       $.each(data, function (index, value) {
//                           $("#name").append('<option value=" ' + value.card_number + '">' + value.card_holder + '</option>');
//                       });
//
//                   });
//               });
//           }
//
//           });
       $(function () {

           $('#month').change(function () {
//                 e.preventDefault();

//               var myYear=2018;
//               var myMonth=8;

               // pattern1
//               var myYear=$('#year');
//               var myMonth=$('#month');

               // pattern2
               var myYear=$('#year').val();
               var myMonth=$('#month').val();

//               var myYear=parseInt($('#year'));
//               var myMonth=parseInt($('#month'));

               console.log("myYear:"+myYear);
               console.log("myMonth:"+myMonth);

//               var myJSON = '{ "year":"'+myYear+'", "month":"'+myMonth+'}';
               var myJSON = { year: myYear, month: myMonth};
               //var myJSON = { year: 2018, month: 8};
               console.log("myjson:"+myJSON);

               $.ajax({
                   type: "get",
                   cache: false,
                   dataType: 'json',
                   data:myJSON,
                   meta:'csrf-token',
                   contentType:'charset=UTF-8',
                   url: "ajax-name"

               })

                       .success(function( response) {
//                           handleData(data);
//                 $.get('ajax-name',function (data) {
                           console.log("shume:"+response);
                           $("#name").empty();
                           $.each(response,function (index,value) {
//                               console.log("shume2"+value.card_holder);
                               $("#name").append('<option value=" '+ value.card_holder+'">'+value.card_holder+'</option>');
                           });

           });
//               $.get('ajax-name',function (data) {
//                   console.log("shume:"+data);


                       });
           });




//           $('#year').click(function () {
////               alert("year selected");
//               $("#month").append("<option> month</option>");
//               $("#name").append("<option> year</option>");
//           });


       $(function() {
       $('#name').select2();
       $('#year').select2();
       $('#month').select2();
        });

//       $(function () {
//
//           $('#submit').click(function () {
//               $('#display').html("welcome");
//
//               $.ajax({
//                   type: "get",
//                   cache: false,
//                   dataType: "json",
//                   data: myMonth,
//                   meta:'csrf-token',
//                   contentType:'charset=UTF-8',
//                   url: "ajax-name"
//
//               })
//
//                       .success(function( data ) {
//                           console.log("shume:"+data);
//                           $("#name").empty();
//                           $.each(data,function (index,value) {
////                               console.log("shume2"+value.card_holder);
//                               $("#name").append('<option value=" '+ value.card_holder+'">'+value.card_holder+'</option>');
//                           });
//                       });
//           });
//
//       });



   </script>


@endsection





