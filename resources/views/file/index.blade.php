@extends('layouts.app')
@section('title')
   Home
@endsection
@section('content')
        <hr>
        <hr>
        <div class="row" align="center" style="background-color: mintcream;width: 105%">
            @if(Session::has('delete_all'))
                <p class="bg-danger pull-right" >{{session('delete_all')}}</p>
            @endif
            @if(Session::has('already'))
                <p class="bg-danger pull-right" >{{session('already')}}</p>
                @endif
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
                <div class="col-sm-1">
                    <input type="button"  align="right" value="表示一覧" id="display" class="btn btn-circle btn-success">
                </div>
                <div class="col-sm-9">
                <ul class="nav navbar-nav container-fluid">
                    <li> <a href="{{URL::to('getImport')}}" class="alert-info " style="padding-bottom: 10px"><span class="glyphicon glyphicon-import">インポート</span></a></li>
                    <li><a href="{{URL::to('getExport')}}" class="alert-info "style="padding-bottom: 10px"><span class="glyphicon glyphicon-export">エクスポート</span></a></li>
                    <li><a href="{{URL::to('/lists')}}" class="alert-info "style="padding-bottom: 10px"><span class="glyphicon glyphicon-download">ダウンロードDATファイル</span></a></li>
                    <li> <button class="btn alert-info " style="padding-bottom: 17px"><span class="glyphicon glyphicon-export">コレパーギエクスポート</span></button></li>
                    <li> <span ></span><input type="button" class=" print btn alert-info glyphicon-print " value="プリント" style="padding-bottom: 17px"></li>
                   <li><a href="{{URL::to('getDelete')}}" class="alert-info" id="delete_all" style="padding-bottom: 10px"><span class="glyphicon glyphicon-trash">すべて削除</span></a></li>
                </ul>
                </div>

            </div>
        {{--Begining of Table used to display per day--}}
    <div class="row" >
        <div class="col-sm-12" style="background-color:#d9edf7">
            <table class="table table-bordered" id="display_list">
                <thead>
                 <tr>
                    <th>日時 </th>
                    <th>ドア</th>
                    <th>入室/退室</th>
                    <th>センサー</th>
                    <th>ステータス</th>
                    <th>会社</th>
                    <th>カード番号</th>
                    <th>名前</th>
                 </tr>
                </thead>
                <tbody id="body_display">
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
                        $("#month").empty();
                        $.each(data,function (index,value) {
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
    $(function(){
        $("#delete_all").click(function(e){
           var reply= confirm("Do you want to delete all? to confirm click OK");
            if(!reply){
                e.preventDefault();
            }
        });
    });
    // used to display the details of data when clicking on display button
    $(function () {
        $('#display').click(function () {
            var myYear=$('#year').val();
            var myMonth=$('#month').val();
//            console.log("myYear:"+myYear);
//            console.log("myMonth:"+myMonth);
            var myJSON = { year: myYear, month: myMonth};
//            console.log("myjson2:"+myJSON);
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
//                            console.log("out:"+value.card_holder);
                            trHTML = '<tr><td>' + value.dates+'</td><td>'+value.door + '</td><td>' + value.status+'</td><td>'+ value.company +  '</td><td>' + value.status2+ '</td><td>' + value.company2+ '</td><td>'
                                    + value.card_number+ '</td><td>' + value.card_holder + '</td></tr>';
                            $("#display_list").append(trHTML);
                            $("#display").click(function (e) {
                                e.preventDefault();
                                $("#body_display").show().empty();
                            });
                        });
                        $(document).ready(function() {
                            $('#display_list').DataTable( {
                                "pageLength": 50,
                                "bRetrieve": true,
                                dom: 'Bfrtip',
                                buttons: [
//                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                ]
                            } );
                        } );
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
                        // applying datatable jquery library
//                     var t= $('#display_list').DataTable( {
//                            "bServerSide":true,
//                            "bProcessing":false,
//                            "sAjaxSource": "view_list",
//                            "iTotalRecords":"10",
//                            "iTotalDisplayRecords":"10",
//                            "sAjaxDataProp" : "data",
//                            "bFilter":true,
//                            "paging": true,
//                            "ordering":false,
//                            "searchable":false,
//                            "info": false,
//                            "sDom": '<"top"i>rt<"bottom"flp><"clear">',
//                            "columnDefs": [ {
//                                "searchable": false,
//                                "orderable": false,
//                                "targets": 0
//                            } ],
//                            "order": [[ 1, 'asc' ]]
//                            //                            "scrollX": true,
////                            "order": [[ 0, "asc" ]],
////                            scrollY: 800
//                        });
//                        t.on( 'order.dt search.dt', function () {
//                            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
//                                cell.innerHTML = i+1;
//                            } );
//                        } );
                    });

        });


    });

</script>
    @endsection
