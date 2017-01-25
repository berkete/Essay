{{--<meta name="csrf-token" content="{{ csrf_token() }}" charset="Shift_JIS" />--}}

@extends('layouts.app')
@section('content')
    <div class="row">
        <div id="file-zone">
            <div id="clickHere" style="margin-left: 290px;margin-top: 100px">

                <form action="postImport" method="post" enctype="multipart/form-data" >
                    <div class="col-sm-6">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <label for="fileselect" class="btn btn-info" style="margin-left: 54px;background-clip: content-box;border-style: dashed">File Import and Upload</label>
                        <input type="file" name="upload[]" class="dropzone " multiple value="Drag and drop" style="align-self: center;background-color:beige;border-color:violet;border-style: dashed">
                    </div>
                    <div class="col-sm-1">
                        <input type="submit" class="btn btn-success"  id="submit" value="Import" style="margin-left: -110px;margin-top: 33px;background-color: darkorchid;">
                    </div>
                </form>
            </div>
        </div>

    </div>
    <script type="text/javascript">
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
