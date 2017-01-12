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
                       {{--<option name="month" value="{{$customer->month}}">{{$customer->month}}</option>--}}
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
                       {{--<option name="name" value="{{$customer->card_holder}}">{{$customer->card_holder}}</option>--}}
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
           <div class="col-sm 3"><input type="button"  align="right" value="+Show/-hide" id="showyear" class="btn btn-success">
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
               {{--@if($displays)--}}
               {{--@foreach($displays as $data)--}}
                 {{--<tr class="success">--}}
                   {{--<td id="dateDisplay"></td>--}}
                   {{--<td></td>--}}
                   {{--<td id="dateDisplay3"></td><td></td>--}}
                     {{--<td></td>--}}
                 {{--</tr>--}}
                   {{--@endforeach--}}
                   {{--@endif--}}
               </tbody>
             </table>


       </div>
       {{--<a href="" class="btn btn-sm btn-info btn-add-more-customers">+year</a>--}}
       {{--<a href="" class="btn btn-sm btn-info btn-add-more-customers2">+Date and Month</a>--}}
       {{--<a href="" class="btn btn-sm btn-info btn-add-more-customers1">+Name</a>--}}




   <script type="text/javascript">


       $(document).ready(function () {
          $(".table").hide();
           $("#showyear").click(function () {
               $(".table").toggle();
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
                               $("#name").append('<option value="'+ value.card_holder+'">'+value.card_holder+'</option>');


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

       // to display the main data

       $(function () {

           $('#showyear').click(function () {
//
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
//                           var mydata=JSON.parse(data);
//                 $.get('ajax-name',function (res) {
                           console.log("shume22:" + data);
//                           $("#dateDisplay").empty();
//                           var rows = $("table#tablee tbody >tr");
//                           var columns;

//                               columns = $(rows[i]).find('td');
                               var trHTML='';
//                           var datas=parseFloat(data);
//                               $.each(JSON.parse(data), function (index, value) {
//
                                 $.each(data, function (index, value) {
////                                       document.write(data[key][index].month);
////                                       console.log("multiple: "+value[index][0].month);
////                                     console.log("multiple: "+value[index].month);
                                     console.log("multiple: "+data[index].month);
                                     console.log("multiple: "+data[index].day);
//////                                     console.log("multiple displa: "+data[index].displays);
                                     console.log("multiple: "+data[index].sumin);
//
//
//
////                                   $.each(data, function (index, value) {
////                                 console.log("multiple"+data);
////                                   console.log("hey"+data.sumin+data.sumout+data.enter+data.exit);
                                   trHTML = '<tr><td>' + data[index].month+'/'+data[index].day + '</td><td>' + data[index].sumin+'時間'+　data[index].minutein+　'分'+  '</td><td>' + data[index].sumout+'時間'+ data[index].minuteout+　'分'+  '</td><td>' + data[index].enter+ '</td><td>' + data[index].exit+ '</td></tr>';
////////                                   trHTML += '<tr><td>' + value + '</td></tr>';
////////
                                   $("#tablee").append(trHTML);
////                                   $("#dateDisplay").prepend(value.day);
//
////                                   $("#dateDisplay3").append(data[index]);
////                                   $('#tablee').DataTable();
//
////                                   $("#dateDisplay3").append(value.time);
////                                   $("#uname").append(value.card_holder)
                                 });



//
//                               var x=$(this).find(value.day).text();
//                               var y=$(this).find(index).val();
//
//                               console.log("shume_day.."+x);
//                               console.log("shume_day.."+y);

//

                       });

           });
       });




   </script>


@endsection





