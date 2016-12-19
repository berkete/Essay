@extends('layouts.app')
@section('content')
<h1>upload</h1>
<div class="row">

    <form action="postImport" method="post" enctype="multipart/form-data">
        <div class="col-sm-3" style="background-color:lightskyblue; ">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="file" name="upload" value="Click to upload" placeholder="++" class="bounceInDown ">

        </div>
        <div class="col-sm-4">
            <input type="submit" class="btn btn-success" value="Import">


        </div>

    </form>

</div>


@endsection