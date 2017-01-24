{{--<meta name="csrf-token" content="{{ csrf_token() }}" charset="Shift_JIS" />--}}

@extends('layouts.app')
@section('content')
    <h1>Import</h1>

    {!! Form::open(['method'=>'POST','action'=>'AdminController@postImport', 'class'=>'dropzone','files'=>true, 'id'=>'real_dropzone']) !!}
    <div class="form-group">

        {{--{!! Form::submit('submit photos',['class'=>'btn btn-primary']) !!}--}}
        {!! Form::hidden('csrf-token', csrf_token(), ['id' => 'csrf-token']) !!}

    </div>
    <div class="dz-message">

    </div>

    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>

    <div class="dropzone-previews" id="dropzonePreview"></div>

    <h4 style="text-align: center;color:#428bca;">Drop images in this area  <span class="glyphicon glyphicon-hand-down"></span></h4>

    <div class="jumbotron how-to-create">
        <ul>
            <li>Images are uploaded as soon as you drop them</li>
            <li>Maximum allowed size of image is 20MB</li>
        </ul>
        <p id="filecounter"></p>
    </div>
    {!! Form::close() !!}

    <div id="preview-template" style="display: none;">

        <div class="dz-preview dz-file-preview">
            <div class="dz-image"><img data-dz-thumbnail=""></div>

            <div class="dz-details">
                <div class="dz-size"><span data-dz-size=""></span></div>
                <div class="dz-filename"><span data-dz-name=""></span></div>
            </div>
            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
            <div class="dz-error-message"><span data-dz-errormessage=""></span></div>

            <div class="dz-success-mark">
                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                    <title>Check</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                    </g>
                </svg>
            </div>

            <div class="dz-error-mark">
                <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                    <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                    <title>error</title>
                    <desc>Created with Sketch.</desc>
                    <defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                            <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                        </g>
                    </g>
                </svg>
            </div>

        </div>
    </div>
    {{--<div class="row">--}}
    {{--<div id="file-zone">--}}
    {{--file files here...--}}
    {{--<div id="clickHere">--}}
    {{--or click here..--}}
    {{--<input type="file" name="file" id="file" />--}}
    {{--<form action="postImport" method="post" enctype="multipart/form-data">--}}
    {{--<div class="col-sm-3" style="background-color:lightskyblue; ">--}}
    {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
    {{--<input type="file" name="upload[]" value="Click to upload" placeholder="++" class="bounceInDown " multiple>--}}
    {{--</div>--}}
    {{--<div class="col-sm-4">--}}
    {{--<input type="submit" class="btn btn-success"  id="submit" value="Import" style="margin-top: 50px">--}}


    {{--</div>--}}

    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}



    {{--</div>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>--}}

    <script type="text/javascript">

        var counter = 0;
        Dropzone.options.realDropzone = {

            uploadMultiple: true,
            parallelUploads: 100,
            maxFilesize: 20,
            previewsContainer: '#dropzonePreview',
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            addRemoveLinks: true,
            dictRemoveFile: 'Remove',
            dictFileTooBig: 'Image is bigger than 20MB',

            // The setting up of the dropzone
            init:function() {

                this.on("removedfile", function(file) {

                    $.ajax({
                        type: 'POST',
                        url: 'postImport',
                        data: {id: file.name, _token: $('#csrf-token').val()},
                        dataType: 'html',
                        success: function(data){
                            var rep = JSON.parse(data);
                            console.log(data);
                            if(rep.code == 200)
                            {
                                counter--;
                                $("#filecounter").text( "(" + counter + ")");
                            }

                        }
                    });

                } );
            },
            error: function(file, response) {
                if($.type(response) === "string")
                    var message = response; //dropzone sends it's own error messages in string
                else
                    var message = response.message;
                file.previewElement.classList.add("dz-error");
                _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i];
                    _results.push(node.textContent = message);
                }
                return _results;
            },
            success: function(file,done) {
                counter++;
                $("#filecounter").text( "(" + counter + ")");
            }
        }


        {{--$.fn.fileZone = function() {--}}
        {{--var buttonId = "clickHere";--}}
        {{--var mouseOverClass = "mouse-over";--}}
        {{--var fileZone = this[0];--}}
        {{--var $fileZone = $(fileZone);--}}
        {{--var ooleft = $fileZone.offset().left;--}}
        {{--var ooright = $fileZone.outerWidth() + ooleft;--}}
        {{--var ootop = $fileZone.offset().top;--}}
        {{--var oobottom = $fileZone.outerHeight() + ootop;--}}
        {{--var inputFile = $fileZone.find("input[type='file']");--}}
        {{--fileZone.addEventListener("dragleave", function() {--}}
        {{--this.classList.remove(mouseOverClass);--}}
        {{--});--}}
        {{--fileZone.addEventListener("dragover", function(e) {--}}
        {{--console.dir(e);--}}
        {{--e.preventDefault();--}}
        {{--e.stopPropagation();--}}
        {{--this.classList.add(mouseOverClass);--}}
        {{--var x = e.pageX;--}}
        {{--var y = e.pageY;--}}

        {{--if (!(x < ooleft || x > ooright || y < ootop || y > oobottom)) {--}}
        {{--inputFile.offset({--}}
        {{--top: y - 15,--}}
        {{--left: x - 100--}}
        {{--});--}}
        {{--} else {--}}
        {{--inputFile.offset({--}}
        {{--top: -300,--}}
        {{--left: -300--}}
        {{--});--}}
        {{--}--}}

        {{--}, true);--}}
        {{--fileZone.addEventListener("file", function(e) {--}}
        {{--this.classList.remove(mouseOverClass);--}}
        {{--}, true);--}}
        {{--}--}}

        {{--$('#file-zone').fileZone();--}}
    </script>
    <style type="text/css">

        #file-zone {
            /*Sort of important*/
            width: 300px;
            /*Sort of important*/
            height: 300px;
            position: absolute;
            left: 50%;
            top: 100px;
            margin-left: -150px;
            border: 2px dashed red;
            border-radius: 20px;
            font-family: Arial;
            text-align: center;
            position: relative;
            line-height: 180px;
            font-size: 20px;
            color:black;
        }

        #file-zone input {
            /*Important*/
            position: relative;
            /*Important*/
            cursor: pointer;
            left: 1px;
            top: 0px;
            /*Important This is only comment out for demonstration purpeses.
                  opacity:0; */
        }


        /*Important*/

        #file-zone.mouse-over {
            border: 2px dashed rgba(0, 0, 0, .5);
            color: rgba(0, 0, 0, .5);
        }


        /*If you dont want the button*/

        #clickHere {
            position: absolute;
            cursor: pointer;
            left: 50%;
            top: 50%;
            margin-left: -50px;
            margin-top: 20px;
            line-height: 26px;
            color: black;
            font-size: 12px;
            width: 100px;
            height: 26px;
            border-radius: 4px;
            background-color: #00b3ee;
        }

        #clickHere:hover {
            background-color: #4499DD;
        }

        .mouse-over {
            background: red;
        }

    </style>
@endsection

// drag and drop

<h1>Import</h1>

{{--<div class="row">--}}
{{--<div id="drop-zone">--}}
{{--file files here...--}}
{{--<div id="clickHere">--}}
{{--or click here..--}}
{{--<input type="file" name="file" id="file" />--}}
{{--<form action="postImport" method="post" enctype="multipart/form-data">--}}
{{--<div class="col-sm-3" style="background-color:lightskyblue; ">--}}
{{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
{{--<input type="file" name="upload[]" value="Click to upload" placeholder="++" class="bounceInDown " multiple>--}}
{{--</div>--}}
{{--<div class="col-sm-4">--}}
{{--<input type="submit" class="btn btn-success"  id="submit" value="Import" style="margin-top: 50px">--}}


{{--</div>--}}

{{--</form>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
<form id="upload" action="/postImport" method="POST" enctype="multipart/form-data">

    <fieldset>
        <legend>HTML File Upload</legend>

        {{--<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />--}}
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        <div>
            <label for="fileselect">Files to upload:</label>
            <input type="file" id="fileselect" name="fileselect[]" multiple="multiple" />
            <div id="filedrag">or drop files here</div>
        </div>

        <div id="submitbutton">
            <button type="submit" id="upload">Upload Files</button>
        </div>

    </fieldset>

</form>

<div id="messages">
    <p>Status Messages</p>
</div>


{{--</div>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>--}}

<script type="text/javascript">
    $(document).ready(function(){
        $("#upload").click(function(){
            function $id(id) {
                return document.getElementById(id);
            }

            //
            // output information
            function Output(msg) {
                var m = $id("messages");
                m.innerHTML = msg + m.innerHTML;
            }
            // call initialization file
            if (window.File && window.FileList && window.FileReader) {
                Init();
            }

            //
            // initialize
            function Init() {

                var fileselect = $id("fileselect"),
                        filedrag = $id("filedrag"),
                        submitbutton = $id("submitbutton");

                // file select
                fileselect.addEventListener("change", FileSelectHandler, false);

                // is XHR2 available?
                var xhr = new XMLHttpRequest();
                if (xhr.upload) {

                    // file drop
                    filedrag.addEventListener("dragover", FileDragHover, false);
                    filedrag.addEventListener("dragleave", FileDragHover, false);
                    filedrag.addEventListener("drop", FileSelectHandler, false);
                    filedrag.style.display = "block";

                    // remove submit button
                    submitbutton.style.display = "inherit";
                }

            }
            // file drag hover
            function FileDragHover(e) {
                e.stopPropagation();
                e.preventDefault();
                e.target.className = (e.type == "dragover" ? "hover" : "");
            }
            // file selection
            function FileSelectHandler(e) {

                // cancel event and hover styling
                FileDragHover(e);

                // fetch FileList object
                var files = e.target.files || e.dataTransfer.files;

                // process all File objects
                for (var i = 0, f; f = files[i]; i++) {
                    ParseFile(f);
                }

            }
            function ParseFile(file) {

                Output(
                        "<p>File information: <strong>" + file.name +
                        "</strong> type: <strong>" + file.type +
                        "</strong> size: <strong>" + file.size +
                        "</strong> bytes</p>"
                );

            }

        });
    });

    //        $.fn.dropZone = function() {
    //            var buttonId = "clickHere";
    //            var mouseOverClass = "mouse-over";
    //            var dropZone = this[0];
    //            var $dropZone = $(dropZone);
    //            var ooleft = $dropZone.offset().left;
    //            var ooright = $dropZone.outerWidth() + ooleft;
    //            var ootop = $dropZone.offset().top;
    //            var oobottom = $dropZone.outerHeight() + ootop;
    //            var inputFile = $dropZone.find("input[type='file']");
    //            dropZone.addEventListener("dragleave", function() {
    //                this.classList.remove(mouseOverClass);
    //            });
    //            dropZone.addEventListener("dragover", function(e) {
    //                console.dir(e);
    //                e.preventDefault();
    //                e.stopPropagation();
    //                this.classList.add(mouseOverClass);
    //                var x = e.pageX;
    //                var y = e.pageY;
    //
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
    //
    //            }, true);
    //            dropZone.addEventListener("file", function(e) {
    //                this.classList.remove(mouseOverClass);
    //            }, true);
    //        }
    //
    //        $('#drop-zone').dropZone();
</script>
<style type="text/css">
    #filedrag
    {
        display: none;
        font-weight: bold;
        text-align: center;
        padding: 1em 0;
        margin: 1em 0;
        color: #555;
        border: 2px dashed #555;
        border-radius: 7px;
        cursor: default;
    }

    #filedrag.hover
    {
        color: #f00;
        border-color: #f00;
        border-style: solid;
        box-shadow: inset 0 3px 4px #888;
    }
    /*#drop-zone {*/
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

    /*#drop-zone input {*/
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

    /*#drop-zone.mouse-over {*/
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