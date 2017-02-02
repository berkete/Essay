<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<link rel="icon" href="{!! asset('images/calcbot-icon.ico') !!}"/>

<head>
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.js"></script>--}}
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
    {{--//Datatable plugin--}}
    <script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src=" https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    {{--//Export plugins--}}
    <script src=" //cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src=" //cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="jQuery-Plugin-To-Export-Table/dist/tableExport.js"></script>
    <script src="Export-Html-Table/src/jquery.table2excel.js"></script>
    {{--//Print plugin--}}
    <script src="DoersGuild-jQuery.print/jQuery.print.js"></script>

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
    {{--//Pagination plug in--}}
    <script type="text/javascript" src="pagination/jquery.simplePagination.js"></script>
    <link type="text/css" rel="stylesheet" href="pagination/simplePagination.css"/>
{{--Bootstrap plugin--}}
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('js/price-range.js')}}"></script>
    <script src="{{asset('js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    {{--Select box plugin--}}
    <link href="select2-4.0.3/dist/css/select2.css" rel="stylesheet" />
    <script src="select2-4.0.3/dist/js/select2.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--<meta name="description" content="{{$description}}">--}}
    <meta name="author" content="Rodrick Kazembe">
    <title>@yield('title')</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/responsive.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{asset('js/html5shiv.js')}}"></script>
    <script src="{{asset('js/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{asset('images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{asset('images/ico/apple-touch-icon-57-precomposed.png')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head><!--/head-->
<header id="header"><!--header-->
    <div class="header-middle" style="background-color:gainsboro;margin-left: -41px"><!--header-middle-->
        <p class="alert alert-info" align="center" style="margin-left: -184px;">オフィスエントリレポート</p>
            <div class="row" style="margin-top: -31px;">
                <div class="col-sm-4"></div>
                <div class="col-sm-5 ">
                        <ul class="nav navbar-nav container-fluid">
                            <li><a href="{{url('/home')}}" class="alert-info"><i class="glyphicon glyphicon-home"></i>ホーム</a></li>
                            <li><a href="{{url('/getsearch')}}"  class=" alert-info btn-sm"><i class="glyphicon glyphicon-floppy-saved"></i>計算(日)</a></li>
                            <li><a href="{{url('/total')}}"  class="alert-info btn-sm"><i class="glyphicon glyphicon-floppy-saved"></i>計算(月)</a></li>
                            <li><a href="{{url('/total_name')}}"  class="alert-info btn-sm"><i class="glyphicon glyphicon-floppy-saved"></i> 計算(年)</a></li>
                        </ul>
                </div>
            </div>
    </div><!--/header-middle-->
    <div>

    </div>
</header><!--/header-->
<div class="container">
    <div class="col-lg-12">
        @yield('content')
    </div>
</div>
    <footer id="footer" style="    margin-right: -40px;margin-left: -10px;margin-bottom:-21px;margin-top: 650px;background-color: lightskyblue"><!--Footer-->
        <div class="footer-top" >
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © {{date('Y')}} Gate in and out management</p>
                    <span><a target="_blank" href="http://www.key-p.com" class="pull-right"></a></span></p>
                </div>
            </div>
        </div>
    </footer>
</html>

