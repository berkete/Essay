@extends('layouts.app')
@section('title',' Each Day and Month total')
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
        </div>
    </div>
    @if($customer1)
       <form action="/searchs" method="post">
           {{ csrf_field() }}
           <div class="row" style="color:cornflowerblue;text-decoration: blink;font-size: large;margin-top:7px;box-shadow: 0 0 0 4px #668cff;">
               <div class="col-sm-3">年</div>
               <div class="col-sm-2">月</div>
               <div class="col-sm-2">名前</div>
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
   {{--@if($customers)--}}
           <div class="col-sm-2">
               <label for="month"></label>
               <select name="month" id="month" class="form-control">
                   <option name="name" value="" selected disabled><i style="color: #00b3ee">月を選択</i></option>
               {{--@foreach($customers as $customer)--}}
                   {{--@endforeach--}}
               </select>
           </div>
   {{--@endif--}}
   {{--@if($customer2)--}}
           <div class="col-sm-3">
               <label for="name"></label>
               <select name="name" id="name" class="form-control">
                   <option name="name" value="" data-placeholder="select year">名前を選択</option>
                   {{--@foreach($customer2 as $customer)--}}
                   {{--@endforeach--}}
               </select>
           </div>
           <div class="col-sm 3" style="-webkit-box-shadow: 5px 8px 15px #B8B;"><input type="button"  align="right" value="表示" id="showyear" class="btn btn-info" style="margin-top: 18px">
               <input type="button"  align="right" value="エクスポート" id="export" class="btn btn-info pull-right" style="margin-top: 18px">
               {{--<button id="" class="btn btn-circle btn-default "></button>--}}

           </div>
        </div>
        </form>

       {{--@endif--}}
   <table style="margin-top:50px" class="table" id="table">
       <thead>
           <tr>
               <th >月/日</th>
               <th>IN</th>
               <th>OUT</th>
               <th>出社</th>
               <th>退社</th>
           </tr>
       </thead>
       <tbody id="displays">
       </tbody>
   </table>
   <script type="text/javascript">
       $(document).ready(function () {
           $('#year').change(function (e) {
               e.preventDefault();
               $.fn.myfunction();
               var myData=$('#year');
               $.ajax({
                   type: "get",
                   cache: false,
                   dataType: "json",
                   data: myData,
                   contentType:'charset=UTF-8',
                   url: "ajax-month",
                   async: true
               })
                       .success(function( data ) {
//                           console.log("shume:"+data);
                           $("#month").empty();
                           $.each(data,function (index,value) {
//                       console.log(value.month,index);
                               $("#month").append('<option value="'+ value.month+'">'+value.month+'</option>');
//                               $("#displays").append(tr);
                               $("#showyear").click(function () {
                                   $("#displays").show().empty();
                               });
                           });
               });

           });
       });

       $.fn.myfunction=function () {
           var myData=$('#year');
           $.ajax({
               type: "get",
               cache: false,
               dataType: "json",
               data: myData,
               contentType:'charset=UTF-8',
               url: "ajax-name2",
               async: true

           })
                   .success(function( data ) {
//                       console.log("shume:"+data);
                       $("#name").empty();
                       $.each(data,function (index,value) {
//                           console.log(value.card_holder,index);
                           $("#name").append('<option value="'+ value.card_holder+'" >'+value.card_holder+'</option>');

                       });
                   });
       };
     $(function() {
           $('#month').change(function () {
               var myYear=$('#year').val();
               var myMonth=$('#month').val();
               var myJSON = { year: myYear, month: myMonth};
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
                           $("#name").empty();
                           $.each(response,function (index,value) {
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
       });
       $(document).ready(function () {
           $("#export").click(function () {
//                    var row = $(this).closest("tr");       // Finds the closest row <tr>
//                    var tds = row.find("td");
               var dt = new Date();
               var day = dt.getDate();
               var month = dt.getMonth() + 1;
               var year = dt.getFullYear();
               var ext=$("#year").val()+"_"+$("#month").val()+"_"+$("#day").val();
               var postfix = day + "_" + month+"_"+year;
               $(".table").tableExport({
                   headings: true,
                   footers: true,
                   formats: ["xls","xlsx","csv"],
                   fileName: postfix+"daily_report_"+ext,
                   bootstrap: true,
                   position: "top",
                   ignoreRows: null,
                   ignoreCols: null
               });
           });
       });
       //display function
       $(function () {
           $('#showyear').click(function () {
               var myYear=$('#year').val();
               var myMonth=$('#month').val();
               var myName=$('#name').val();
               var myJSON = { year: myYear, month: myMonth,name:myName};
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
                                // intializing the table rows
                               var trHTML='';
                               var total_hour_in=0.0;
                               var total_minute_in=0.0;
                               var total_hour_out=0.0;
                               var total_minute_out=0.0;
                               var total_hour=0.0;
                               var total_minute=0.0;
                               var hours_av_exit=0.0;
                               var minutes_av_exit=0.0;
                               var second_av_exit=0.0;
                               var average_enterance;

                           var count=data.length;
                            console.log(count);
                           $.each(data, function (index, value) {
                                     average_enterance=data[index].average_enterance;
                                     var arr_exit=data[index].exit.split(':');
                                     var hours_exit=parseInt(arr_exit[0]);
                                     var minutes_exit=parseInt(arr_exit[1]);
                                     var seconds_exit=parseInt(arr_exit[2]);
                                   if(hours_exit>11){
                                       hours_av_exit=hours_av_exit+hours_exit;
                                       minutes_av_exit=minutes_av_exit+minutes_exit;
                                       second_av_exit=second_av_exit+seconds_exit;

                                   }
                                  else {
                                       count=count-1;
                                   }
                                   trHTML = '<tr><td>' + data[index].month+'/'+data[index].day + '</td><td>' + Math.abs(data[index].sumin)+'時間'+　data[index].minutein+　'分'+  '</td><td>' + data[index].sumout+'時間'+ data[index].minuteout+　'分'+  '</td><td>' + data[index].enter+ '</td><td>' + data[index].exit+ '</td></tr>';
                                   $("#displays").append(trHTML);
                                   $("#displays").css("background-color", "white");
                                     //Total time inside the office
                                     total_hour_in=total_hour_in+Math.abs(data[index].sumin);
                                     total_minute_in=total_minute_in+data[index].minutein;
                                     if(total_minute_in>59){
                                         total_hour_in=total_hour_in+1.0;
                                         total_minute_in=total_minute_in-60.0;
                                     }
                                     //total Time outside the office

                                     total_hour_out=total_hour_out+data[index].sumout;
                                     total_minute_out=total_minute_out+data[index].minuteout;
                                     if(total_minute_out>59){
                                         total_hour_out=total_hour_out+1.0;
                                         total_minute_out=total_minute_out-60.0;
                                     }
                                     total_hour=total_hour_in+total_hour_out;
                                     total_minute=total_minute_in+total_minute_out;
                                     if(total_minute>59){
                                         total_hour=total_hour+1.0;
                                         total_minute=total_minute-60.0;
                                     }
                                     $("#showyear").click(function (e) {
                                         e.preventDefault();
                                         $("#displays").show().empty();
                                     });
                                 });
                           var average_hour_exit=Math.round(hours_av_exit/count);
                           var average_minute_exit=Math.round(minutes_av_exit/count)+Math.round(60*((hours_av_exit/count)-average_hour_exit));
                           var average_second_exit=Math.round(second_av_exit/count);
                           if(average_minute_exit>59){
                               average_hour_exit+=1.0;
                               average_minute_exit-=60.0;
                           }
                           if(average_second_exit>59){
                               average_minute_exit+=1.0;
                               average_second_exit-=60.0;
                           }
                           if(average_hour_exit<10){
                               average_hour_exit="0"+average_hour_exit;
                           }
                           if(average_minute_exit<10){
                               average_minute_exit="0"+average_minute_exit;
                           }
                           if(average_second_exit<10){
                               average_second_exit="0"+average_second_exit;
                           }
                           var average_exit_time=average_hour_exit+":"+average_minute_exit+":"+average_second_exit;
                           $("#total_time").append("中にいる時間　合計 &emsp;&emsp;"+total_hour_in+"時間"+total_minute_in+"分<br/>"+"外にいる時間　合計 &emsp;"+total_hour_out+"時間"+total_minute_out+"分<br/>"+"合計時間 &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;   "+total_hour+"時間"+total_minute+"分<br>"+"平均出社時間&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;"+average_enterance+"<br>平均退社時間&emsp;&emsp;&emsp;&emsp;&emsp;"+average_exit_time);
                           $("#showyear").click(function (e) {
                               e.preventDefault();
                               $("#total_time").show().empty();
                           });
                       });
           });
       });

   </script>
@endsection





