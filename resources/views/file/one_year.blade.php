@extends('layouts.app')
@section('title')
    Each Year Data
@endsection
@section('content')
    {{--Begining of Table used to display per day--}}
<h3>年間　合計時間</h3>
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
        {{--@if($card_holders)--}}
            {{--<div class="col-sm-2" style="margin-top: -19px">--}}
                {{--<label for="month"></label>--}}
                {{--<select name="name" id="name" class="form-control">--}}
                    {{--<option name="name" value="" selected disabled><i style="color: #00b3ee">名前を選択</i></option>--}}
                    {{--@foreach($card_holders as $card_holder)--}}
                    {{--@endforeach--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--@endif--}}
            <div class="col-sm-1">
                <input type="button"  align="right" value="表示一覧" id="display" class="btn btn-circle btn-default">
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-2">
                <button class="btn btn-default ">エクスポート</button>
            </div>
            <div class="col-sm-1 ">    <input type="button" class=" print btn btn-circle btn-default pull-left " value="プリント" style="margin-left: -73px;">
            </div>
    </div>
    <div class="row" >
        <div class="col-sm-12" style="background-color:#d9edf7">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Year </th>
                        <th>Name</th>
                        <th>Total_time_inside</th>
                        <th>Total_time_outside</th>
                        <th>Total_time</th>
                    </tr>
                </thead>
                <tbody id="display_list">
                </tbody>
            </table>
        </div>
    </div>
    <div id="list_display"></div>
    <script type="text/javascript">
        // used to display months when changing year
//        $(document).ready(function () {
//            $('#year').change(function (e) {
//                e.preventDefault();
//                var myData=$('#year');
//                $.ajax({
//                    type: "get",
//                    cache: false,
//                    dataType: "json",
//                    data: myData,
//                    contentType:'charset=UTF-8',
//                    url: "ajax-name2"
//                })
//                        .success(function( data ) {
//                            console.log("shume:"+data);
//                            $("#name").empty();
//                            $.each(data,function (index,value) {
//                                console.log(value.month,index);
//                                $("#name").append('<option value="'+ value.card_holder+'" disabled>'+value.card_holder+'</option>');
//                            });
//                        });
//            });
//        });
        //Applying the selector jquery library
        $(function() {
            $('#year').select2();
            $('#name').select2();
        });
        $("button").click(function(){
            var row = $(this).closest("tr");       // Finds the closest row <tr>
            var tds = row.find("td");
            var dt = new Date();
            var day = dt.getDate();
            var month = dt.getMonth() + 1;
            var year = dt.getFullYear();
            var postfix = day + "/" + month+"/"+year;
            console.log("Closest"+tds[0]);
            $(".table").table2excel({
                exclude: ".noExl",
                name: "Excel Document Name",
                filename: postfix+"Yearly_report",
                fileext: ".xls",
                exclude_img: true,
                exclude_links: true,
                exclude_inputs: true //do not include extension
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
        // used to display the details of data when clicking on display button
        $(function () {
            $('#display').click(function () {
                var myYear=$('#year').val();
                var myName=$('#name').val();
                console.log("myYear:"+myYear);
                console.log("myName:"+myName);
                var myJSON = { year: myYear, name: myName};
                console.log("myjson2:"+myJSON);
                $.ajax({
                    type: "get",
                    cache: false,
                    data:myJSON,
                    dataType: 'json',
                    accept:true,
                    meta:'csrf-token',
                    contentType:'application/json,charset=UTF-8',
                    url: "total_name_list"
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
                                if (data[index].card_holder!=="未登録カード" && total_hour>0.0){
                                    trHTML = '<tr><td>' + (index+1)+ '</td><td>'+myYear+ '</td><td>' + data[index].card_holder+ '</td><td>' +Math.abs(data[index].sumin)+'時間'+　data[index].minutein+　'分' + '</td><td>' + data[index].sumout+'時間'+ data[index].minuteout+　'分'+ '</td><td>' + Math.abs(total_hour)+'時間'+ total_minute+　'分'+ '</td></tr>';
                                    $("#display_list").append(trHTML);
                                    $("#display_list").css("background-color", "white");
                                }
                                $("#display").click(function (e) {
                                    e.preventDefault();
                                    $("#display_list").show().empty();
                                });
                            });
                    });
            });
        });
    </script>
@endsection
