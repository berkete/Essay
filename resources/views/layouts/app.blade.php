<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<link rel="icon" href="{!! asset('images/iride-ui-icon-pack-300x300.ico') !!}"/>

<head>
    {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.js"></script>--}}
    <script src="{{asset('js/jquery.js')}}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
    <script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">

    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('js/price-range.js')}}"></script>
    <script src="{{asset('js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <link href="select2-4.0.3/dist/css/select2.css" rel="stylesheet" />
    <script src="select2-4.0.3/dist/js/select2.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--<meta name="description" content="{{$description}}">--}}
    <meta name="author" content="Rodrick Kazembe">
    <title>Home</title>
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
    <div class="header-middle" style="background-color:deepskyblue;margin-left: -41px"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{url('/home')}}"><i class="glyphicon glyphicon-home"></i>ホム/Home</a></li>
                            <li><a href="{{url('/getsearch')}}"><i class="glyphicon glyphicon-floppy-saved"></i>計算/Calculation</a></li>
                        </ul>
                    </div>
                </div>
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
<footer id="footer" style="    margin-right: -40px;margin-left: -10px;margin-bottom:33px;margin-top: 500px;background-color: lightskyblue"><!--Footer-->
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

