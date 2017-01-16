<meta name="csrf-token" content="{{ csrf_token() }}">

{{--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.css">--}}

{{--<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>--}}

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
       <div class="row" style="color: dodgerblue" id="mainselect">
           <div class="col-sm-3">
               <label for="year"></label>
               <select name="year" id="year" class="form-control" placeholder="Select">
                   <option value="" selected disabled> 年を選択</option>
                   @foreach($customer1 as $customer)
                       <option  name="year"  value="{{$customer->year}}" data-placeholder="select year">{{$customer->year}}</option>
                   @endforeach
               </select>
           </div>
        @endif
       @if($customers)

           <div class="col-sm-3">

               <label for="month"></label>
               <select name="month" id="month" class="form-control">
                   <option name="name" value="" selected disabled><i style="color: #00b3ee">月を選択</i></option>
               @foreach($customers as $customer)
                   @endforeach
               </select>
           </div>
        @endif
       @if($customer2)
           <div class="col-sm-3">
               <label for="name"></label>
               <select name="name" id="name" class="form-control">
                   <option name="name" value="" data-placeholder="select year">名前を選択</option>
                   @foreach($customer2 as $customer)
                   @endforeach
               </select>
           </div>
            <div class="col-sm-3" style="    margin-top: -19px;">　
                <span class="input-group-btn">
                <button type="submit" class="btn btn-success" value="Search">Search
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>

            </div>
         </div>

        </form>
     @endif
       <div class="row">

           <div class="col-sm-9" id="uname">User name:-
           </div>
           <div class="col-sm 3"><input type="button"  align="right" value="+Show" id="showyear" class="btn btn-success">
               {{--<div class="col-sm 3"><input type="button"  align="right" value="-detach" id="detach" class="btn btn-success">--}}

               </div>

           <table class="table" id="tablee" style="margin-top:110px ">
               <thead>
                 <tr>
                   <th>月/日</th>
                   <th>IN</th>
                   <th>OUT</th>
                     <th>出社</th>
                     <th>退社</th>
                 </tr>
               </thead>
               <tbody>
               </tbody>
             </table>
       </div>
   <script type="text/javascript">


       $(document).ready(function () {

          $(".table").hide();
           $("#showyear").click(function (e) {
               e.preventDefault();
               $(".table").show().empty();
           });

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
                       $("#month").append('<option value="'+ value.month+'">'+value.month+'</option>');
                   });

               });
           });
       });
       $(function () {
           $('#month').change(function () {
               var myYear=$('#year').val();
               var myMonth=$('#month').val();
               console.log("myYear:"+myYear);
               console.log("myMonth:"+myMonth);
               var myJSON = { year: myYear, month: myMonth};
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
                           console.log("shume:"+response);
                           $("#name").empty();

                           $.each(response,function (index,value) {
//                               console.log("shume2"+value.card_holder);
                               $("#name").append('<option value="'+ value.card_holder+'">'+value.card_holder+'</option>');
                           });
           });
                       });
           });
       // Data selector jquery library call
       $(function() {
       $('#name').select2();
       $('#year').select2();
       $('#month').select2();
        });
       //display function
       $(function () {
           $('#showyear').click(function () {
               var myYear=$('#year').val();
               var myMonth=$('#month').val();
               var myName=$('#name').val();
               console.log("myYear:"+myYear);
               console.log("myMonth:"+myMonth);
               console.log("myName:"+myName);
               var myJSON = { year: myYear, month: myMonth,name:myName};
               console.log("myjson2:"+myJSON);
               $.ajax({
                   type: "get",
                   cache: false,
                   data:myJSON,
                   dataType: 'json',
                   accept:true,
                   meta:'csrf-token',
                   contentType:'application/json,charset=UTF-8',
                   url: "display"
               })
                       .success(function(data) {
                           console.log("shume22:" + data);
                                // intializing the table rows
                               var trHTML='';
                                 $.each(data, function (index, value) {
                                   trHTML = '<tr><td>' + data[index].month+'/'+data[index].day + '</td><td>' + data[index].sumin+'時間'+　data[index].minutein+　'分'+  '</td><td>' + data[index].sumout+'時間'+ data[index].minuteout+　'分'+  '</td><td>' + data[index].enter+ '</td><td>' + data[index].exit+ '</td></tr>';
                                   $("#tablee").append(trHTML);
//                                    $("#uname").append(value.card_holder).show().remove();
//                                     console.log(data[index].card_holder);
                                 });
                       });

           });
       });

   </script>
@endsection





