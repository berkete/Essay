@extends('layouts.app')
@section('title','Each month')


@section('content')
<h3>月間　合計時間</h3>
    <div class="row">
        @if($years)
            <div class="col-sm-2" style="margin-top: -19px">
                <label for="year"></label>
                <select name="year" id="year" class="form-control" placeholder="Select">
                    <option value="" selected disabled> 年を選択</option>
                    @foreach($years as $year)
                        <option  name="year"  value="{{$year->year}}" data-placeholder="select year">{{$year->year}}</option>
                    @endforeach
                </select>
            </div>
        @endif
        @if($months)
            <div class="col-sm-2" style="margin-top: -19px">
                <label for="month"></label>
                <select name="month" id="month" class="form-control">
                    <option name="name" value="" selected disabled><i style="color: #00b3ee">月を選択</i></option>
                    @foreach($months as $month)
                    @endforeach
                </select>
            </div>
        @endif
            <div class="col-sm-1">
                <input type="button"  align="right" value="表示一覧" id="display" class="btn btn-circle btn-default">
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-2">
                <button class="btn btn-circle btn-default ">エクスポート</button>
            </div>
            <div class="col-sm-1 ">    <input type="button" class=" print btn btn-circle btn-default pull-left " value="プリント" style="margin-left: -73px;">
            </div>
    </div>
    <div class="row" >
        <div class="col-sm-12" style="background-color:#d9edf7">
            <table class="table table-bordered" id="monthly_report">
                <thead>
                    <tr >
                        {{--<th>No.</th>--}}
                        {{--<th>年/月 </th>--}}
                        {{--<th>カード番号 </th>--}}
                        <th>名前</th>
                        <th>IN</th>
                        <th>OUT</th>
                        <th>合計時間 </th>
                        <th>入口平均的</th>
                        <th>出口平均的</th>
                    </tr>
                </thead>
                <tbody id="table_calculation">
                </tbody>
            </table>
        </div>
    </div>
    <div id="list_display"></div>
        <script type="text/javascript">
        // used to display months when changing year
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
                            $("#month").empty();
                            $.each(data,function (index,value) {
                                console.log(value.month,index);
                                $("#month").append('<option value="'+ value.month+'">'+value.month+'</option>');
                            });
                        });
            });
        });
        //Applying the selector jquery library
        $(function() {
            $('#year').select2();
            $('#month').select2();
        });
        //Export function
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
                filename: postfix+"Monthly_report",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true //do not include extension
        });
        });
        //Print function
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
        // used to display the details of data when clicking on display button
        $(function () {
            $('#display').click(function () {
                var myYear=$('#year').val();
                var myMonth=$('#month').val();
                console.log("myYear:"+myYear);
                console.log("myMonth:"+myMonth);
                var myJSON = { year: myYear, month: myMonth};
                console.log("myjson2:"+myJSON);
                $.ajax({
                    type: "get",
                    cache: false,
                    data:myJSON,
                    dataType: 'json',
                    accept:true,
                    meta:'csrf-token',
                    contentType:'application/json,charset=UTF-8',
                    url: "total_list"
                })
                        .success(function(data) {
                            // intializing the table rows
                            var trHTML='';
                            $.each(data, function (index, value) {
                                var total_hour=data[index].sumin+data[index].sumout;
                                var total_minute=data[index].minutein+data[index].minuteout;
                                if (total_minute>59){
                                    total_hour=total_hour+1.0;
                                    total_minute=total_minute-60.0;
                                }
                                if (data[index].card_holder!=="未登録カード" && total_hour>0.0 && data[index].card_number!=="未登録カード" ){
//                                    trHTML = '<tr><td>' + (index+1)+ '</td><td>'+myYear+'/'+ data[index].month+ '</td><td>' + data[index].card_number+ '</td><td>' + data[index].card_holder+ '</td><td>'+Math.abs(data[index].sumin)+'時間'+　data[index].minutein+　'分' + '</td><td>' + data[index].sumout+'時間'+ data[index].minuteout+　'分'+ '</td><td>' + Math.abs(total_hour)+'時間'+ total_minute+　'分'+ '</td><td>' +data[index].enter +'</td><td>' +data[index].exit+'</td></tr>';
                                    trHTML = '<tr><td>' + data[index].card_holder+ '</td><td>'+Math.abs(data[index].sumin)+'時間'+　data[index].minutein+　'分' + '</td><td>' + data[index].sumout+'時間'+ data[index].minuteout+　'分'+ '</td><td>' + Math.abs(total_hour)+'時間'+ total_minute+　'分'+ '</td><td>' +data[index].enter +'</td><td>' +data[index].exit+'</td></tr>';
                                    $("#monthly_report").append(trHTML);
                                    $("#monthly_report").css("background-color", "white");

                                }
                                $("#display").click(function (e) {
                                    e.preventDefault();
                                    $("#table_calculation").show().empty();
                                });
                            });
                        });
            });
         });
    </script>
@endsection
