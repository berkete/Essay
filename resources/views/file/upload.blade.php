@extends('layouts.app')
@section('title','Import and Upload')
@section('content')
    <div class="row">
                <form action="postImport" method="post" enctype="multipart/form-data" ondragstart='ParseFile()'>
                    <div class="col-sm-4">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <h4>ファイルのインポート＆アップロード</h4>
                        {{--<label for="fileselect" class="btn btn-info" style="margin-left: 54px;background-clip: content-box;border-style: dashed"></label>--}}
                        <input type="file" name="upload[]" class="dropzone " id="upload" multiple value="Drag and drop" style="align-self: center;background-color:white;border-color:azure;border-style: dashed">
                       <input type="submit" id="import" class="btn btn-success"  value="インポート＆アップロード" style="margin-left: 63px;margin-top: 11px;background-color: black;">

                    </div>
                    <div class="col-sm-2" id="submitbutton">
                    </div>
                </form>
        <div id="messages" class="col-sm-6">
            <table class="table" id="property_list" style="width: 70%">
                <thead>
                  <tr>
                    <th>ファイル名</th>
                    <th>ファイル サイズ</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="success">
                  </tr>
                </tbody>
              </table>
            <p>ステータス</p>
        </div>
    </div>
    <script type="text/javascript">
        $('#upload').bind('change', function(e) {
            var uploadFile=document.getElementById('upload');
            var trhtml='';
            var counts=(uploadFile.files).length;
            if(counts<35) {
                $('#messages').append("<strong>ファイル数</strong>:" + counts);
                $.each(uploadFile.files, function (key, value) {
//                    console.log(value.type);
                    trhtml = '<tr class="success"><td>' + value.name + '</td><td>' + Math.floor(value.size / 1024) + "KB" + '</td></tr>';
                    $('#property_list').append(trhtml);
                });
            }
            else{
                alert("35ファイル以上は、アップロードできません。 \n ファイルを減らしてください。");
                e.preventDefault();
                $('#import').prop('disabled', true);
            }
        });
        $(function () {
            $("#import").click(function (e) {
                var uploadFile=document.getElementById('upload');
                var counts=(uploadFile.files).length;
                 if(counts<1) {
                     var imports = confirm("ファイルを選んでください");
                         e.preventDefault();
                 }
            });
        });
    </script>
@endsection
