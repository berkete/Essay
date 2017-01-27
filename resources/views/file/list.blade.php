@extends('layouts.app')
@section('content')

    <h1>DAT ファイル一覧</h1>

    @if(Session::has('delete_media'))
        <p class="bg-danger pull-right" >{{session('delete_media')}}</p>
        @endif
    @if($files)
        <h1></h1>
@if(Session::has('download_media'))
    <p class="bg-success pull-right" >{{session('download_media')}}</p>

@endif
        <a href="getDeleteall"  class="btn btn-danger pull-right" id="delete_all_dat"><i class="glyphicon glyphicon-trash"></i>すべて削除</a>
        <table class="table">
            <thead>
            <tr class="danger">
                <th>ファイル名（ダウンロード）</th>
                <th>ファイルサイズ</th>
                <th>アップロード日時</th>
                <th>ファイルタイプ</th>

                <th></th>

            </tr>
            </thead>
            <?php
            date_default_timezone_set("Asia/Tokyo");

            $offset = 10; //get this as input from the user, probably as a GET from a link
            $quantity = 10; //number of items to display
            $filelist = scandir($files,1);

            //get subset of file array
            $selectedFiles = array_slice($filelist, $offset-1, $quantity);

            //output appropriate items

            ?>
            @foreach($filelist as $key=>$value)
                {{--@foreach($files as $file)--}}
                @if(!($value==".DS_Store"||$value=='..'||$value=='.'))
                    <tbody id="table_page">
                    <tr class="success">
                        <td><a href="/getDownload/{{$value}}" class="btn btn-large pull-left"><i class="fa fa-download"></i>{{$value}}</a></td>
                        {{--{{$size[]=filesize($file)}}--}}
                        <td><a href="#"></a>{{(floor(filesize($files.'/'.$value)/1024)."KB")}}</td>
                        <td><a href="#"></a>{{date('jS F Y h:i:s A',filectime($files.'/'.$value))}}</td>
                        <td><a href="#"></a>{{mime_content_type($files.'/'.$value)}}</td>

                        <td><a href="getDeletes/{{$value}}"  class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i>削除</a></td>
                    </tr>
                    @endif
                    {{--@endforeach--}}
                    @endforeach
                    </tbody>
                <p id="page"></p>
        </table>

    @endif
<script type="text/javascript">
    $(function(){
        $("#delete_all_dat").click(function(e){
            var reply= confirm("Do you want to delete all? to confirm click OK");

            if(!reply){
                e.preventDefault();
            }
        });
    });
    $(function() {
        $("#table_page").pagination({
            items: 5,
            itemsOnPage: 1,
            cssStyle: 'light-theme'
        });
    });
</script>


@endsection