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
                        <input type="file" name="upload[]" class="dropzone " id="upload" multiple value="Drag and drop" style="align-self: center;background-color:beige;border-color:azure;border-style: dashed">
                       <input type="submit" class="btn btn-success"  value="Import and Upload" style="margin-left: 63px;margin-top: 11px;background-color: black;">

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
    <hr>
    <hr>
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

//        "<p>File information: <strong>" + file.name +
//                                    "</strong> type: <strong>" + file.type +
//                                    "</strong> size: <strong>" + file.size +
//                                    "</strong> bytes</p>";
//        $(document).ready(function(){
//                function $id(id) {
//                    return document.getElementById(id);
//                }
//
//                //
//                // output information
//                function Output(msg) {
//                    var m = $id("messages");
//                    m.innerHTML = msg + m.innerHTML;
//                }
//                // call initialization file
//                if (window.File && window.FileList && window.FileReader) {
//                    Init();
//                }
//
//                //
//                // initialize
//                function Init() {
//
//                    var fileselect = $id("fileselect"),
//                            filedrag = $id("filedrag"),
//                            submitbutton = $id("submitbutton");
//
//                    // file select
//                    fileselect.addEventListener("change", FileSelectHandler, false);
//
//                    // is XHR2 available?
//                    var xhr = new XMLHttpRequest();
//                    if (xhr.upload) {
//
//                        // file drop
//                        filedrag.addEventListener("dragover", FileDragHover, false);
//                        filedrag.addEventListener("dragleave", FileDragHover, false);
//                        filedrag.addEventListener("drop", FileSelectHandler, false);
//                        filedrag.style.display = "block";
//
//                        // remove submit button
//                        submitbutton.style.display = "inherit";
//                    }
//
//                }
//                // file drag hover
//                function FileDragHover(e) {
//                    e.stopPropagation();
//                    e.preventDefault();
//                    e.target.className = (e.type == "dragover" ? "hover" : "");
//                }
//                // file selection
//                function FileSelectHandler(e) {
//
//                    // cancel event and hover styling
//                    FileDragHover(e);
//
//                    // fetch FileList object
//                    var files = e.target.files || e.dataTransfer.files;
//
//                    // process all File objects
//                    for (var i = 0, f; f = files[i]; i++) {
//                        ParseFile(f);
//                    }
//
//                }
//                function ParseFile(file) {
//
//                    Output(
//                            "<p>File information: <strong>" + file.name +
//                            "</strong> type: <strong>" + file.type +
//                            "</strong> size: <strong>" + file.size +
//                            "</strong> bytes</p>"
//                    );
//                }
//        });
//        $.fn.fileZone = function() {
////            var buttonId = "clickHere";
//            var mouseOverClass = "mouse-over";
//            var fileZone = this[0];
//            var $fileZone = $(fileZone);
//            var ooleft = $fileZone.offset().left;
//            var ooright = $fileZone.outerWidth() + ooleft;
//            var ootop = $fileZone.offset().top;
//            var oobottom = $fileZone.outerHeight() + ootop;
//            var inputFile = $fileZone.find("input[type='file']");
//            fileZone.addEventListener("dragleave", function() {
//                this.classList.remove(mouseOverClass);
//            });
//            fileZone.addEventListener("dragover", function(e) {
//                console.dir(e);
//                e.preventDefault();
//                e.stopPropagation();
//                this.classList.add(mouseOverClass);
//                var x = e.pageX;
//                var y = e.pageY;
//                if (!(x < ooleft || x > ooright || y < ootop || y > oobottom)) {
//                    inputFile.offset({
//                        top: y - 15,
//                        left: x - 100
//                    });
//                } else {
//                    inputFile.offset({
//                        top: -400,
//                        left: -400
//                    });
//                }
//            }, true);
//            fileZone.addEventListener("file", function(e) {
//                this.classList.remove(mouseOverClass);
//            }, true);
//        }
//        $('#file-zone').fileZone();
    </script>
    <style type="text/css">
        /*#file-zone {*/
            /*!*Sort of important*!*/
            /*width: 300px;*/
            /*!*Sort of important*!*/
            /*height: 300px;*/
            /*position: absolute;*/
            /*left: 50%;*/
            /*top: 100px;*/
            /*margin-left: -150px;*/
            /*border: 2px dashed red;*/
            /*border-radius: 20px;*/
            /*font-family: Arial;*/
            /*text-align: center;*/
            /*position: relative;*/
            /*line-height: 180px;*/
            /*font-size: 20px;*/
            /*color:black;*/
        /*}*/
        /*#file-zone input {*/
            /*!*Important*!*/
            /*position: relative;*/
            /*!*Important*!*/
            /*cursor: pointer;*/
            /*left: 1px;*/
            /*top: 0px;*/
            /*!*Important This is only comment out for demonstration purpeses.*/
                  /*opacity:0; *!*/
        /*}*/
        /*!*Important*!*/
        /*#file-zone.mouse-over {*/
            /*border: 2px dashed rgba(0, 0, 0, .5);*/
            /*color: rgba(0, 0, 0, .5);*/
        /*}*/
        /*!*If you dont want the button*!*/
        /*#clickHere {*/
            /*position: absolute;*/
            /*cursor: pointer;*/
            /*left: 50%;*/
            /*top: 50%;*/
            /*margin-left: -50px;*/
            /*margin-top: 20px;*/
            /*line-height: 26px;*/
            /*color: black;*/
            /*font-size: 12px;*/
            /*width: 100px;*/
            /*height: 26px;*/
            /*border-radius: 4px;*/
            /*background-color: #00b3ee;*/
        /*}*/
        /*#clickHere:hover {*/
            /*background-color: #4499DD;*/
        /*}*/
        /*.mouse-over {*/
            /*background: red;*/
        /*}*/
    </style>
@endsection
