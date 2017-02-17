@extends('layouts.app')
@section('content')
    <h3>daily report</h3>

    @if($daily_years)
        {{--<form action="/searchs" method="post">--}}
        {{--{{ csrf_field() }}--}}
        <div class="row" style="color:cornflowerblue;text-decoration: blink;font-size: large;margin-top:7px">
            <div class="col-sm-3">年</div>
            <div class="col-sm-2">月</div>
            <div class="col-sm-2">日</div>
        </div>
        <div class="row" style="color:cornflowerblue;background-color: lightblue" id="mainselect">

            <div class="col-sm-2">
                <label for="years"></label>
                <select name="year" id="year" class="form-control" placeholder="Select">
                    <option value="" selected disabled> 年を選択</option>
                    @foreach($daily_years as $customer)
                        <option  name="year" id="year" value="{{$customer->year}}">{{$customer->year}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-sm-2">
                <label for="name"></label>
                <select name="months" id="month" class="form-control">
                    <option name="months" value="" data-placeholder="select month">月を選択</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="name"></label>
                <select name="days" id="day" class="form-control">
                    <option name="days" value="" data-placeholder="select day">日を選択</option>
                </select>
            </div>
            <div class="col-sm-2">
                <p>カレンダー: <input id="fullDate" type="text" style="display:block">
                </p>

                <div id="datepicker" ></div>


            </div>
            <div class="col-sm-4" style="margin-top: 10px">
                <input type="button"  align="right" value="表示" id="hyoji" class="btn btn-success" >
                <button class="btn btn-circle btn-default ">エクスポート</button>
                <input type="button" class=" print btn btn-circle btn-default  " value="プリント" >
            </div>
        </div>
        <table style="margin-top:50px" class="table">
            <thead>
            <tr>
            <thead>
            <tr>
                <th >名前</th>
                <th>IN</th>
                <th>OUT</th>
                <th>出社</th>
                <th>退社</th>
            </tr>
            </thead>
            <tbody id="displays">
            </tbody>
        </table>
        <style type="text/css">
            .ui-datepicker{
                background: dodgerblue;
                border: 1px solid #555;
                color: #EEE;
            }
            .ui-datepicker-trigger{
                background-color: dodgerblue;
                border: 1px solid #555;
                color: #AAAAAA;
                margin-top: 15px;
            }

        </style>
        <script type="text/javascript">
//            var months;
            $(document).ready(function () {
                var months;
                $.fn.year= $('#year').change(function (e) {
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
                                var selected = "";
                                var flag_month=0;
                                var x=$("#fullDate").val();
                                var datesplit=x.split('/');
                                months=datesplit[0];

                                // calender onClose action flag
                                var flag = 0;
                                if($("#fullDate").val()!==""){
                                    flag = 1;
                                }

                                // create select box option
                                $.each(data,function (index,value) {
                                    if(flag==1) {
                                        if (value.month== months) {
                                            selected = "selected";
                                        }
                                        else{
                                            selected = "";

                                        }

                                    }
//                                    console.log("database month"+value.month);
//                                    console.log("fulldate month"+months);
//                                   if(value.month!==months){
//                                        alert("select");
//                                        return false;
//                                    }
                                    $("#month").append('<option value="' + value.month + '"' + selected + '>' + value.month + '</option>');
//                                    }
//                                    else{
//                                        console.log("Value month2"+value.month,index);

//                                        $("#month").append('<option value="' + value.month + '">' + value.month + '</option>');

//                                    }

                                    $("#showyear").click(function () {
                                        $("#displays").show().empty();
                                    });
                                });
                            });

                });

            });
            $(".print").click(function() {
                $(".table").print({
                    globalStyles: true,
                    mediaPrint: false,
                    stylesheet: null,
                    noPrintSelector: ".no-print",
                    iframe: true,
                    append: null,
                    prepend: null,
                    manuallyCopyFormValues: true,
                    deferred: $.Deferred(),
                    timeout: 250,
                    title: null,
                    doctype: '<!doctype html>'
                });
            });
            $("button").click(function(){
                var row = $(this).closest("tr");       // Finds the closest row <tr>
                var tds = row.find("td");
                var dt = new Date();
                var day = dt.getDate();
                var month = dt.getMonth() + 1;
                var year = dt.getFullYear();
                var postfix = day + "/" + month+"/"+year;
                $(".table").table2excel({
                    exclude: ".noExl",
                    name: "Excel Document Name",
                    filename: postfix+"Daily_report",
                    fileext: ".xls",
                    exclude_img: true,
                    exclude_links: true,
                    exclude_inputs: true //do not include extension
                });
            });
            $(document).ready(function () {
                $("#fullDate").datepicker({
                            showOn:"button",
                            showButtonPanel: true,
                            buttonText: "Choose",
                            buttonImage:'images/calendar.png',
                            changeMonth: true,
                            changeYear: true,

//                      beforeShowDay: function(input,inst){
//                        var year = $(this).parent().find("#year").val();
//                        var month = $(this).parent().find("#month").val();
//                        var date = $(this).parent().find("#day").val();
//                        $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
//                    },
                      onClose:function (dateText,ins) {
                          var datesplit=dateText.split('/');
                          var year=datesplit[2];
                          var months=datesplit[0];
                          var days=datesplit[1];
                          console.log(year);

//                          $('#year').removeAttr('disabled',true);
//                          $(this).parents().find("#year").val(year);
//                          $(this).parents().find("#month").val(months);
//                          $(this).parents().find("#day").val(days);
                          var Year_data=$('#year');
//                          console.log("my year"+Year_data);
                          // exist? not exist? from database
                        var result=  $.ajax({
                              type: "get",
                              cache: false,
                              dataType: "json",
                              data: Year_data,
                              contentType:'charset=UTF-8',
                              url: "ajax-month",
                              async: true
                          })
                                  .success(function( data ) {
//                                      console.log("shume:"+data);
                                      $("#month").empty();
                                      // create select box option
                                      $.each(data,function (index,value) {
//                                          console.log("new"+value.month);
//                                          console.log("calandder"+months);
//                                          console.log("data index"+data[index].month);

//                                          if(value.month==months){
//                                              alert("the same");
////                                              return true;
//                                          }
//                                          else{
//                                              alert("not the same");
////                                              return false;
//                                          }


                                      });
                                  });
//                          var result = XXXXX;
                          if(result) {
                              $("#year").val(year).trigger('change');

                          }else{
                              return false;
                       }

                          // create monthly list from database
                          // create daily list from database


//                          console.log("the year value"+$("#year").val());
//                          console.log("the year value"+year);
//
//                          console.log("the month value"+months);
//                          console.log("the day value"+days);

//                          if($("#fullDate").val()!==""){
//                              if($("#month").val()!==months || $("#day").val()!==days){
//                                  confirm("choose another day");
//                                  $("#fullDate").val()==$("#fullDate").val("");
//                                  $("#month").val()==$("#month").val("");
//                                  $("#day").val()==$("#day").val("");
//
////                                  return false;
//                              }
//                              else {
//                                  return false;
//                              }


//
//
// if(sel_year){
//                                $("#month").val(months);
////                                alert("selected");
//                            }

                          // calendar's month selected monthly list
//alert(months);
                          // calendar's daily selected monthly list

//                          alert("hey");



                          $.fn.myfunction();
                          $("#day").val(days);

//                          $.fn.call_month();
//                           $("#day").val(days)
                      }

                });



            });
//            $.fn.call_month=function () {
//                $("#fullDate").datepicker({
//                    beforeShowDay: function(input,inst){
////                        var year = $(this).parent().find("#year").val();
////                        var month = $(this).parent().find("#month").val();
////                        var date = $(this).parent().find("#day").val();
////                        $(this).datepicker( "setDate" , year + "/" + month + "/" + date)
////                    },
//                    onSelect:function (dateText,ins) {
//                        var datesplit=dateText.split('/');
//                        var year=datesplit[2];
//                        var months=datesplit[0];
//                        var days=datesplit[1];
//                        console.log(year);
//
//
//                    }
//                });
//
//            };

            $.fn.myfunction=function () {
                var myData=$('#year');
                $.ajax({
                    type: "get",
                    cache: false,
                    dataType: "json",
                    data: myData,
                    contentType:'charset=UTF-8',
                    url: "ajax-daily2",
                    async: true

                })
                        .success(function( data ) {
                            var selected;
                            var flag=0;

                            if($("#fullDate")!==""){
                                flag = 1;
                            }
                            var x = $("#fullDate").val();
                            var datesplit = x.split('/');
                            var year = datesplit[2];
                            var months = datesplit[0];
                            var days = datesplit[1];
//                            console.log("shume:"+data);
                            $("#day").empty();
                            $.each(data,function (index,value) {

                                if (flag==1)
                                {
//                                    alert(days);
                                    if (value.day==days) {
                                        selected = "selected";
//                                        return true;
                                    }
                                    else {
//                                        alert("different days");
                                        selected = "";
//                                        return false;
                                    }
                                    $("#day").append('<option value="' + value.day + '"' + selected + '>' + value.day + '</option>');

                                }
//                                else {
//                                    $("#day").append('<option value="' + value.day + '">' + value.day + '</option>');
//                                }


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
                        url: "ajax-daily"
                    })
                            .success(function( response) {
                                $("#day").empty();
                                $.each(response,function (index,value) {
//                            if(value.card_holder!=='未登録カード'){
                                    $("#day").append('<option value="'+ value.day+'">'+value.day+'</option>');
//                            }
                                });
                            });
                });
            });
            // Data selector jquery library call
            $(function() {
                $('#day').select2();
                $('#year').select2();
                $('#month').select2();
            });

            //display function
            $(function () {
                $('#hyoji').click(function () {
                    var myYear=$('#year').val();
                    var myMonth=$('#month').val();
                    var myDay=$('#day').val();
                    var myJSON = { year: myYear, month: myMonth,day:myDay};
                    console.log("myjson"+myJSON);
                    $.ajax({
                        type: "get",
                        cache: false,
                        data:myJSON,
                        dataType: 'json',
                        accept:true,
                        meta:'csrf-token',
                        contentType:'application/json,charset=UTF-8',
                        url: "daily_display"

                    })
                            .success(function(data) {
                                console.log("shume2:"+data);
                                // intializing the table rows
                                var trHTML='';
                                $.each(data, function (index, value) {
                                    console.log("value:"+value.card_holder+"index:"+index);
                                    if(data[index].card_holder!=='未登録カード'){
                                        trHTML = '<tr><td>' + data[index].card_holder + '</td><td>' + data[index].sumin+'時間'+　data[index].minutein+　'分'+  '</td><td>' + data[index].sumout+'時間'+ data[index].minuteout+　'分'+  '</td><td>' + data[index].enter+ '</td><td>' + data[index].exit+ '</td></tr>';
                                        $("#displays").append(trHTML);
                                        $("#displays").css("background-color", "white");
                                    }

                                    //Total time inside the office
                                    $("#hyoji").click(function (e) {
                                        e.preventDefault();
                                        $("#displays").show().empty();
                                    });
                                });
                            });
                });
            });

        </script>

@endsection