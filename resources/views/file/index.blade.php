@extends('layouts.app')
@section('content')
        <hr>
        <p class="alert alert-info" align="center">Office Entry Report!</p>
        <hr>
        {{--begining of the menu--}}
        <div class="row" align="center" style="background-color: mintcream">
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
            <div class="btn-group">
                <input type="button"  align="right" value="表示/Display" id="display" class="btn btn-circle btn-success">

                 <button type="button" class="btn btn-info"><span class="glyphicon glyphicon glyphicon-export">輸出する(Export)</span></button>
                 <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                 </button>
                 <ul class="dropdown-menu" role="menu" id="export-menu">
                    <li ID="export-to-excel"><a href="{{URL::to('/getExport')}}">Export To excel</a></li>
                    <li class="divider"></li>
                    <li><a href="{{URL::to('/update')}}">Update userTable</a></li>
                    <li><a href="#">Others</a></li>
                 </ul>
                <a href="{{URL::to('getImport')}}" class="btn btn-info"><span class="glyphicon glyphicon-import">インポート/Import</span></a>
                 <a href="{{URL::to('getDelete')}}" class="btn btn-danger"><span class="glyphicon glyphicon-trash">すべて削除/Delete All</span></a>
            </div>
        </div>
        {{--End of the menu--}}
        {{--Begining of Table used to display per day--}}
    <div class="row" >
        <div class="col-sm-12" style="background-color:#d9edf7">
            <table class="table table-bordered" id="display_list">
                <thead>
                 <tr>
                    <th>Working Date </th>
                    <th>Enterance Door</th>
                    <th>status</th>
                    <th>Company</th>
                    <th>status2</th>
                    <th>Company2</th>
                    <th>card number</th>
                    <th>Holder</th>
                 </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
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
                url: "view_list"
            })
                    .success(function(data) {
                        // intializing the table rows
                        var trHTML='';
                        $.each(data, function (index, value) {
                            console.log("out:"+value.card_holder);
                            trHTML = '<tr><td>' + value.dates+'</td><td>'+value.door + '</td><td>' + value.status+'</td><td>'+ value.company +  '</td><td>' + value.status2+ '</td><td>' + value.company2+ '</td><td>'
                                    + value.card_number+ '</td><td>' + value.card_holder + '</td></tr>';
                            $("#display_list").append(trHTML);
                        });
                        // applying datatable jquery library
                        $('#display_list').DataTable( {
                            "bServerSide":true,
                            "bProcessing":true,
                            "sAjaxSource": "view_list",
                            "iTotalRecords":"10",
                            "iTotalDisplayRecords":"10",
                            "sAjaxDataProp" : "data",
                            "paging": true,
                            "ordering":false,
                            "searchable":false,
                            "info": false
//                            "scrollX": true,
//                            "order": [[ 0, "asc" ]],
//                            scrollY: 800
                        });
                    });

        });
    });
</script>
    @endsection
