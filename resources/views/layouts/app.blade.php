<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<link rel="icon" href="{!! asset('images/iride-ui-icon-pack-300x300.ico') !!}"/>

<head>

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
</head><!--/head-->

<header id="header"><!--header-->


    <div class="header-middle" style="background-color:deepskyblue;margin-left: -41px"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="{{url('')}}"><img src="{{asset('images/main/logo.png')}}" alt="" /></a>
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-user"></i> {{Auth::check() ? Auth::user()->name : 'Account'}}</a></li>
                            <li><a href="{{url('/register')}}"><i class="fa fa-crosshairs"></i>{{Auth::check()? 'Registered':'Register'}}</a></li>
                            <li><a href="{{url('/home')}}"><i class="fa fa-coffee"></i>home</a></li>
                            <li><a href="{{url('/main')}}"><i class="fa fa-coffee"></i>main</a></li>
                            <li><a href="{{url('/getsearch')}}"><i class="fa fa-coffee"></i>search</a></li>

                            <li><a href="{{Auth::check() ? url('/logout') : url('/login')}}"><i class="fa fa-lock"></i> {{Auth::check() ? 'Logout' : 'Login'}}</a></li>
                            {{--<li><a href="{{ url('/register') }}">{{$post->title}}</a></li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->
    <div>

    </div>

    {{--<div class="header-bottom" style="margin-top: -33px"><!--header-bottom-->--}}
        {{--<div class="container">--}}
            {{--<div class="row" style="background-color: greenyellow">--}}
                {{--<div class="col-sm-9">--}}
                    {{--<div class="navbar-header">--}}
                        {{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">--}}
                            {{--<span class="sr-only">Toggle navigation</span>--}}
                            {{--<span class="icon-bar"></span>--}}
                            {{--<span class="icon-bar"></span>--}}
                            {{--<span class="icon-bar"></span>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                    {{--@if(Auth::check())--}}
                        {{--<div class="mainmenu pull-left">--}}
                            {{--<ul class="nav navbar-nav collapse navbar-collapse">--}}
                                {{--<li><a href="#" class="active">Home</a></li>--}}
                                {{--<li><a href="{{url('/service')}}">Services</a></li>--}}
                                {{--<li><a href="{{url('/welcome/show')}}">Blog lists</a></li>--}}
                                {{--<li><a href="#" >Contact Us</a></li>--}}
                                {{--<li><a href="#">Media</a></li>--}}
                                {{--@if(Auth::user()->role->name=='author')--}}
                                {{--<li><a href="{{route('author.post.create')}}">Create Posts</a></li>--}}
                                {{--<li><a href="{{route('author.post.index')}}">Posts</a></li>--}}

                                {{--<a href="{{url('/service')}}"><i class="fa fa-coffee"></i>Service</a>--}}
                                {{--@endif--}}
                                {{--@if(Auth::user()->role->name=='administrator' && Auth::user()->is_active==1)--}}
                                {{--<li><a href="{{route('admin.index')}}">Admin page</a></li>--}}

                                {{--@endif--}}




                            {{--</ul>--}}
                        {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-sm-3">--}}
                    {{--<div class="search_box pull-right">--}}
                        {{--<form action="/posts" method="POST" role="search">--}}
                            {{--{{ csrf_field() }}--}}
                            {{--<div class="input-group">--}}
                                {{--<input type="text" class="form-control" name="q"--}}
                                       {{--placeholder="Search Posts"> <span class="input-group-btn">--}}
                                {{--<button type="submit" class="btn btn-default">--}}
                                {{--<span class="glyphicon glyphicon-search"></span>--}}
                                 {{--</button>--}}
                                {{--</span>--}}
                            {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--@endif--}}


            {{--</div>--}}


        {{--</div>--}}


    {{--</div>--}}
    {{--</div><!--/header-bottom-->--}}
</header><!--/header-->

<div class="container">

    {{--<div class="row">--}}

    {{--<div class="col-md-2" style=";background-color: lightskyblue;margin-top: -25px;margin-left: -100px">--}}


    {{--<!-- Blog Categories Well -->--}}
    {{--<div class="well">--}}
    {{--<h4>Upload file</h4>--}}
    {{--<div class="row">--}}
    {{--<div class="col-lg-6">--}}
    {{--<ul class="list-unstyled">--}}
    {{--<li><a href="#">dsfds</a>--}}
    {{--</li>--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<!-- /.row -->--}}
    {{--</div>--}}

    {{--<!-- Side Widget Well -->--}}
    {{--<div class="well">--}}
    {{--<h4>Date</h4>--}}
    {{--<p>{{\Carbon\Carbon::Now('Japan')}}</p>--}}
    {{--</div>--}}

    {{--</div>--}}
    <div class="col-lg-12">

        @yield('content')

    </div>

    <!-- Door Sidebar Widgets Column -->


</div>
</div>

<footer id="footer" style="    margin-right: -40px;margin-left: -10px;margin-top: 500px;background-color: lightskyblue"><!--Footer-->
    <div class="footer-top" >
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>

    <div class="footer-widget " style="align-content: center">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="companyinfo">
                        <h2><span>D</span>-data display</h2>
                        <p>This</p>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="single-widget">
                        <h2>Service</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Online Help</a></li>
                            <li><a href="#">Contact Us</a></li>

                        </ul>
                    </div>
                </div>


                <div class="col-sm-3">
                    <div class="single-widget">
                        <h2>information</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Company Information</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Store Location</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="address">
                        <img src="{{asset('images/home/map.png')}}" alt="" />
                        <p>Kobe Sannomiya Motomachi</p>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1 pull-right" style="    margin-top: -60px" >
                </div>


            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © {{date('Y')}} Gate in and out management</p>
                <span><a target="_blank" href="http://www.shume.com" class="pull-right"> |  Designed by Shume Enjoy</a></span></p>
            </div>
        </div>
    </div>
</footer>


<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('js/price-range.js')}}"></script>
<script src="{{asset('js/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
</html>

