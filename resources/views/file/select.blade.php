<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>
<body>
<button id="hide">Hide</button>
<button id="show">Show</button>
<div class="row" >
    <div class="col-sm-4" style="background-color: #00b3ee">How</div>
    <div class="col-sm-4">are</div>
    <div class="col-sm-4">You</div>

</div>

<div id="div1" style="width:80px;height:80px;display:none;background-color:red;"></div><br>
<div id="div2" style="width:80px;height:80px;display:none;background-color:green;"></div><br>
<div id="div3" style="width:80px;height:80px;display:none;background-color:blue;"></div>
<p>Slide me</p>
<div style="border: rgba(239, 151, 255, 0.68)" class="panel-body">hey</div>
<div style="border: red;background-color: blue"></div>
<script>
    $(document).ready(function(){
        $("#hide").click(function () {
            $(".row").toggle();
        });
        $("#show").click(function () {
            $(".row").show(3000);

        });



    });


</script>
</body>
</html>



