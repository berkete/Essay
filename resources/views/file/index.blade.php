
@extends('layouts.app')

@section('content')

<hr>
<p class="alert alert-info" align="center">Office Entry Report!</p>
<hr>
<div class="row" align="center">

    <a href="{{URL::to('getImport')}}" class="btn btn-info">Import</a>

    <div class="btn-group">
        <button type="button" class="btn btn-info">Export</button>
        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">

            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
            <ul class="dropdown-menu" role="menu" id="export-menu">
                <li ID="export-to-excel"><a href="{{URL::to('/getExport')}}">Export To excel</a></li>
                <li class="divider"></li>
                <li><a href="{{URL::to('/update')}}">Update userTable</a></li>
                <li><a href="#">Others</a></li>


            </ul>

    </div>

    <a href="{{URL::to('getDelete')}}" class="btn btn-danger">Delete All</a>


</div>
<div class="row" >
    <div class="col-sm-10" style="background-color:lightskyblue">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Date</th>
                <th>IN</th>
                <th>OUT</th>
                <th>首位しゃ</th>
                <th>status</th>
                <th>Company</th>
                <th>status2</th>
                <th>Company2</th>
                <th>card number</th>
                <th>Holder</th>
            </tr>
            </thead>
            @if($users)
                @foreach($users as $user)




            <tbody>
            <tr class="success">
                <td>{{$user->created_at}}</td>
                <td>{{$user->in}}</td>
                <td>{{$user->out}}</td>
                <td>{{$user->door}}</td>
                <td>{{$user->status}}</td>
                <td>{{$user->company}}</td>
                <td>{{$user->status2}}</td>
                <td>{{$user->company2}}</td>
                <td>{{$user->card_number}}</td>
                <td>{{$user->card_holder}}</td>


            </tr>
            </tbody>
            @endforeach
            @endif

        </table>

    </div>
    <div class="col-sm-2" style="background-color:white">
        <p> upload dat file</p>
        <div class="col-sm-9">
           <form action="search" method="post">




            <input type="text" class="form-control" placeholder="search.."  name="search"/>
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
           </form>
        </div>

        <p> </p>
    </div>












    <div class="col-sm-2">
<h1>part2</h1>
    </div>

</div>



    @endsection