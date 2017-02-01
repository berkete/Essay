@extends('layouts.app')
@section('content')
    {{--Begining of Table used to display per day--}}
<h1>Total Time per month</h1>
    @if($years)
        <div class="col-sm-1" style="margin-top: -19px">
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
        <div class="col-sm-1" style="margin-top: -19px">
            <label for="month"></label>
            <select name="month" id="month" class="form-control">
                <option name="name" value="" selected disabled><i style="color: #00b3ee">月を選択</i></option>
                @foreach($months as $month)
                @endforeach
            </select>
        </div>
    @endif
    <input type="button"  align="right" value="表示一覧" id="display" class="btn btn-circle btn-success">

    <div class="row" >
        <div class="col-sm-12" style="background-color:#d9edf7">
            <table class="dataTable table-bordered" id="example">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Year/Month </th>
                    <th>Name</th>
                    <th>Total_time_inside</th>
                    <th>Total_time_outside</th>
                    <th>Total_time</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <table id="table_calculation">
                <tbody>
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
        $(document).ready(function() {
            $('#example').DataTable( {
//                columns: [
//                    { title: "No." },
//                    { title: "Year/Month" },
//                    { title: "Name" },
//                    { title: "Total_time_inside" },
//                    { title: "Start Total_time_outside" },
//                    { title: "Total_time" }
//                ],
                paging:false,
                "bRetrieve": true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
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
                                if (data[index].card_holder!=="未登録カード" && total_hour>0.0){
                                    trHTML = '<tr><td>' + (index+1)+ '</td><td>'+myYear+'/'+ data[index].month+ '</td><td>' + data[index].card_holder+ '</td><td>' +Math.abs(data[index].sumin)+'時間'+　data[index].minutein+　'分' + '</td><td>' + data[index].sumout+'時間'+ data[index].minuteout+　'分'+ '</td><td>' + Math.abs(total_hour)+'時間'+ total_minute+　'分'+ '</td></tr>';
                                    $("#example").append(trHTML);
                                    $("#example").css("background-color", "white");

                                }
                                $("#display").click(function (e) {
                                    e.preventDefault();
                                    $("#example").show().empty();
                                });
                            });


                        });



        });
        });


    </script>
@endsection
