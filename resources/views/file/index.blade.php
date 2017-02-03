@extends('layouts.app')
@section('title')
   Home
@endsection
@section('content')
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
                    <li> <button class="btn alert-info " style="padding-bottom: 17px"><span class="glyphicon glyphicon-export">このページをエクスポート</span></button></li>
                    <li> <input type="button" class=" print btn alert-info glyphicon-print " value="印刷" style="padding-bottom: 17px"></li>
                   <li><a href="{{URL::to('getDelete')}}" class="alert-info" id="delete_all" style="padding-bottom: 10px"><span class="glyphicon glyphicon-trash">すべて削除</span></a></li>
                </ul>
                </div>
            </div>
        {{--Begining of Table used to display per day--}}
        @if($users)
    <div class="row" >
        <div class="col-sm-12" style="background-color:#d9edf7">
            <table class="table table-bordered" id="display_list" style="width: 100%">
                <thead>
                 <tr>
                     <th>No.</th>
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
                <tbody id="body_display" style="background-color: white;width: 100%">
                </tbody>
            </table>
            <table class="table table-bordered" id="body_displays" style="width: 100%">
                @foreach($users as $key=>$user)
                <tbody  style="background-color: white">
                <td style="width: 3%;">{{$key+1}}</td>
                <td style="width: 14%;">{{$user->created_at}}</td>
                <td style="width: 3%;">{{$user->door}}</td>
                <td style="width: 12%;">{{$user->status}}</td>
                <td style="width: 12%;">{{$user->company}}</td>
                <td style="width: 14%;">{{$user->status2}}</td>
                <td style="width: 10%;">{{$user->company2}}</td>
                <td style="width: 10%;">{{$user->card_number}}</td>
                <td style="width: 9%;">{{$user->card_holder}}</td>
                </tbody>
                @endforeach
                    {{--<p class="pull-right"></p>{{$users->render()}}--}}

            </table>

        </div>
    </div>
    @endif
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
                url: "ajax-month",
//                async:true
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
            $("#body_displays").show().empty();
            var myYear=$('#year').val();
            var myMonth=$('#month').val();
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
                url: "view_list",
//                async:false
            })
                    .success(function(data) {
                        // intializing the table rows
                        var trHTML='';
                        $.each(data, function (index, value) {
//                            console.log("out:"+value.card_holder);
                            trHTML = '<tr><td>' +(index+1)+ '</td><td>'+value.dates+'</td><td>'+value.door + '</td><td>' + value.status+'</td><td>'+ value.company +  '</td><td>' + value.status2+ '</td><td>' + value.company2+ '</td><td>'
                                    + value.card_number+ '</td><td>' + value.card_holder + '</td></tr>';
                            $("#display_list").append(trHTML);
                            $("#display").click(function (e) {
                                e.preventDefault();
                                $("#body_display").show().empty();
                            });
                        });
                        $(document).ready(function() {
                         $('#display_list').DataTable( {
                             pageLength:50,
//                                stateSave: false,
                             "bRetrieve": true,
                              paging:true,
                              info:false,
                              dom: 'Bfrtip',
                              buttons: [
//                                    'copy', 'csv', 'excel', 'pdf', 'print'
                                ]
                               
                            });
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
                    });

        });


    });

</script>
    @endsection
