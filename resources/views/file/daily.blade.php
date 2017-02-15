@extends('layouts.app')
@section('content')
<h3>日報</h3>

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
                        <option  name="year"  value="{{$customer->year}}" data-placeholder="select year">{{$customer->year}}</option>
                    @endforeach
                </select>
            </div>
            @endif
                <div class="col-sm-3">
                    <label for="name"></label>
                    <select name="months" id="month" class="form-control">
                        <option name="months" value="" data-placeholder="select month">月を選択</option>
                    </select>
                </div>
            <div class="col-sm-3">
                <label for="name"></label>
                <select name="days" id="day" class="form-control">
                    <option name="days" value="" data-placeholder="select day">日を選択</option>
                </select>
            </div>
            <div class="col-sm-3">
                <p>カレンダーから選択: <input id="fullDate" type="text" style="display:none">
                </p>
            </div>
                <div cla ss="col-sm-1"><input type="button"  align="right" value="表示" id="hyoji" class="btn btn-success" style="margin-top: 18px">
                </div>
            <input type="hidden" id="datepicker" />
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

    $(document).ready(function () {
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
    $(document).ready(function() {
        $("#fullDate").datepicker({
            showOn:"button",
//            buttonImageOnly: true,
//            showButtonPanel: true,

            buttonText: "Choose",
            buttonImage:'images/calendar_icon.png',
            changeMonth: true,
            changeYear: true,
            onSelect: function(dateText, inst) {
                var datesplit=dateText.split('/');
                var year=datesplit[2];
                var months=datesplit[0];
                var days=datesplit[1];
                console.log("day"+days);
                console.log("month"+months);
                console.log("year"+year);
                $("#month").html('<option value="'+ months+'">'+months+'</option>');
                $("#day").html('<option value="'+ days+'">'+days+'</option>');
                $("#year").html('<option value="'+ year+'">'+year+'</option>');
//                    $("#year option[value=year]").prop('selected', true);
//                    $("#month option[value='months']").attr("selected", true);
//                    $("#day option[value='days']").attr("selected", true);


                $("#year").val(year).prop('selected',true);
                $("#month").val(months).prop('selected',true);
                $("#day").val(days).prop('selected',true);
            }

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
            url: "ajax-daily2",
            async: true

        })
                .success(function( data ) {
                       console.log("shume:"+data);
                    $("#day").empty();
                    $.each(data,function (index,value) {
                           console.log(value.day,index);
                        $("#day").append('<option value="'+ value.day+'" >'+value.day+'</option>');

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