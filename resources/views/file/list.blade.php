@extends('layouts.app')
@section('title')
   DAT list
@endsection
@section('content')
    <h1>DAT ファイル一覧</h1>
    @if(Session::has('delete_media'))
        <p class="bg-danger pull-right" >{{session('delete_media')}}</p>
    @endif
    @if($files)
        @if(Session::has('download_media'))
            <p class="bg-success pull-right" >{{session('download_media')}}</p>
        @endif
        <a href="getDeleteall"  class="btn btn-danger pull-right" id="delete_all_dat"><i class="glyphicon glyphicon-trash"></i>すべて削除</a>
        <div id="pagination">Simple Pagination</div>
        <table class="table" id="content">
            <thead>
                <tr class="danger">
                    <th>No.</th>
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
                @if(!($value==".DS_Store"||$value=='..'||$value=='.'))
                    <tbody>
                        <tr class="success">
                            <td>{{$key+1}}</td>
                            <td><a href="/getDownload/{{$value}}" class="btn btn-large pull-left"><i class="fa fa-download"></i>{{$value}}</a></td>
                            <td><a href="#"></a>{{(floor(filesize($files.'/'.$value)/1024)."KB")}}</td>
                            <td><a href="#"></a>{{date('jS F Y h:i:s A',filectime($files.'/'.$value))}}</td>
                            <td><a href="#"></a>{{mime_content_type($files.'/'.$value)}}</td>
                            <td><a href="getDeletes/{{$value}}"  class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i>削除</a></td>
                        </tr>
                    </tbody>
                @endif
            @endforeach
        </table>
    @endif
    <script type="text/javascript">
    $(function(){
        //Confirm button before deleting the files
        $("#delete_all_dat").click(function(e){
            var reply= confirm("Do you want to delete all? to confirm click OK");
            if(!reply){
                e.preventDefault();
            }
        });
    });
    $(function($) {
        var items = $("#content tbody tr");
        var numItems = items.length;
        var perPage = 22;
        items.slice(perPage).show();
        // now setup pagination
        $("#pagination").pagination({
            items: numItems,
            itemsOnPage: perPage,
            cssStyle: "light-theme",
            onPageClick: function(pageNumber) { // this is where the magic happens
                // someone changed page, lets hide/show trs appropriately
                var showFrom = perPage * (pageNumber - 1);
                var showTo = showFrom + perPage;
                items.hide() // first hide everything, then show for the new page
                        .slice(showFrom, showTo).show();
            }
        });
    });
</script>


@endsection