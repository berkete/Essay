@extends('layouts.app')
@section('content')
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <p class="alert alert-info" align="center">時間計算ページ</p>
        </div>
        <div class="col-sm-4">
            <p class="alert alert-info" align="center">セレクトボックスを選んで表示ボタンをクリックしてください。</p>
        </div>
        <div class="col-sm-4">
            <p id="total_time" class="alert alert-info" align="center"></p>
            {{--<p id="total_time" style="background-color: rgba(255, 255, 255, 0.68);text-align: right;font-style: italic;"></p>--}}
        </div>
    </div>
    <hr>
   @if($customer1)
       <form action="/searchs" method="post">
           {{ csrf_field() }}
           <div class="row" style="color:cornflowerblue;text-decoration: blink;font-size: large;margin-top:7px">
               <div class="col-sm-3">年</div>
               <div class="col-sm-3">月</div>
               <div class="col-sm-3">名前</div>
           </div>
        <div class="row" style="color:cornflowerblue;background-color: lightblue" id="mainselect">
           <div class="col-sm-2">
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
           <div class="col-sm-2">
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
           <div class="col-sm 3"><input type="button"  align="right" value="表示" id="showyear" class="btn btn-success" style="margin-top: 18px">
           </div>
        </div>
        </form>

   @endif
   <table style="margin-top:50px">
       <thead>
       <tr>
       <thead>
       {{--Table used to display the static headers because we going to use show().empty method --}}
       <tr>
           <th style="padding-right: 152px">月/日</th>
           <th style="padding-right: 214px">IN</th>
           <th style="padding-right: 234px">OUT</th>
           <th style="padding-right: 200px">出社</th>
           <th style="padding-right: 152px">退社</th>
       </tr>
       </thead>
       <tfoot id="total_time">
       <tr>
       </tr>
       </tfoot>
       <tbody>
       </tbody>

       {{--Table used to display the ajax data--}}
   </table>
           <table class="table" id="table_calculation">
               <tbody>
               </tbody>

           </table>

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
                                if(value.card_holder!=='未登録カード'){
                                    $("#name").append('<option value="'+ value.card_holder+'">'+value.card_holder+'</option>');
                                }

                           });
           });
                       });
           });
       // Data selector jquery library call
       $(function() {
       $('#name').select2();
       $('#year').select2();
       $('#month').select2();
//       $('#table_calculation').DataTable();
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
                               var total_hour_in=0.0;
                               var total_minute_in=0.0;
                               var total_hour_out=0.0;
                               var total_minute_out=0.0;
                               var total_hour=0.0;
                               var total_minute=0.0;
                                 $.each(data, function (index, value) {
                                   trHTML = '<tr><td>' + data[index].month+'/'+data[index].day + '</td><td>' + data[index].sumin+'時間'+　data[index].minutein+　'分'+  '</td><td>' + data[index].sumout+'時間'+ data[index].minuteout+　'分'+  '</td><td>' + data[index].enter+ '</td><td>' + data[index].exit+ '</td></tr>';
                                   $("#table_calculation").append(trHTML);
                                   $("#table_calculation").css("background-color", "white");

                                     //Total time inside the office
                                     total_hour_in=total_hour_in+data[index].sumin;
                                     total_minute_in=total_minute_in+data[index].minutein;
                                     if(total_minute_in>59){
                                         total_hour_in=total_hour_in+1;
                                         total_minute_in=total_minute_in-60;
                                     }
                                     //total Time outside the office
                                     total_hour_out=total_hour_out+data[index].sumout;
                                     total_minute_out=total_minute_out+data[index].minuteout;
                                     if(total_minute_out>59){
                                         total_hour_out=total_hour_out+1;
                                         total_minute_out=total_minute_out-60;
                                     }
                                     total_hour=total_hour_in+total_hour_out;
                                     total_minute=total_minute_in+total_minute_out;
                                     if(total_minute>59){
                                         total_hour=total_hour+1;
                                         total_minute=total_minute-60;
                                     }
                                 });

                           $("#total_time").append("中にいる時間　合計 &emsp;"+total_hour_in+"時間"+total_minute_in+"分<br/>"+"外にいる時間　合計 &emsp;"+total_hour_out+"時間"+total_minute_out+"分<br/>"+"合計時間 &emsp;&emsp;&emsp;&emsp;   "+total_hour+"時間"+total_minute+"分");
                           $("#showyear").click(function (e) {
                               e.preventDefault();
                               $("#total_time").show().empty();
                           });


                           console.log("In"+total_hour_in+":"+total_minute_in);
                           console.log("Out"+total_hour_out+":"+total_minute_out);



                       });

           });
       });

   </script>
@endsection





