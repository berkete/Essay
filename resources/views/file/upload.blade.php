{{--<meta name="csrf-token" content="{{ csrf_token() }}" charset="Shift_JIS" />--}}

@extends('layouts.app')
@section('content')
    <div class="row">
        {{--<div id="file-zone">--}}
            {{--<div id="clickHere" style="margin-left: 290px;margin-top: 100px">--}}

                <form action="postImport" method="post" enctype="multipart/form-data" ondragstart='ParseFile()'>
                    <div class="col-sm-4">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <label for="fileselect" class="btn btn-info" style="margin-left: 54px;background-clip: content-box;border-style: dashed">File Import and Upload</label>
                        <input type="file" name="upload[]" class="dropzone " id="upload" multiple value="Drag and drop" style="align-self: center;background-color:white;border-color:azure;border-style: dashed">
                       <input type="submit" id="import" class="btn btn-success"  value="Import and Upload" style="margin-left: 63px;margin-top: 11px;background-color: black;">

                    </div>
                    <div class="col-sm-2" id="submitbutton">
                    </div>
                </form>
            {{--</div>--}}
        {{--</div>--}}
        <div id="messages" class="col-sm-6">
            <table class="table" id="property_list" style="width: 70%">
                <thead>
                  <tr>
                      <th>File Name</th>
                    <th>File Size</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="success">
                  </tr>
                </tbody>
              </table>
            <p>Status Messages</p>
        </div>
    </div>
    {{--<hr>--}}
    {{--<hr>--}}
    <script type="text/javascript">

        $('#upload').bind('change', function() {
            var uploadFile=document.getElementById('upload');
            var trhtml='';
            var counts=(uploadFile.files).length;
            console.log(counts);
            $('#messages').append("<strong>Number of files</strong>:"+counts);
        $.each(uploadFile.files,function (key ,value) {
            console.log(value.type);

            trhtml='<tr class="success"><td>' + value.name+'</td><td>'+Math.floor(value.size/1024) + "KB"+'</td></tr>';
            $('#property_list').append(trhtml);
        });

//            alert('This file size is: ' + this.files[0].size/1024/1024 + "MB"+this.files[0].name);
        });
        $(function () {
            $("#import").click(function (e) {
//                  var uploads=("#import").val();
                  var imports=confirm("please select the value before importing");
                  if (!imports){
                      e.preventDefault();

                }


            });



        });
    </script>
@endsection
