<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
{{--<script src="jquery-1.11.2.js"></script>--}}
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#optionList').change(function () {

                var selectedOption=$('#optionList option:selected');
                console.log(selectedOption);
                $('#divResult').html('value='+selectedOption.val()+"text"+selectedOption.text());

            });

        });

//        function handleSelect(myForm) {
//            var x=myForm.optionList.options[myForm.selectedIndex];
//            alert(x);
//
//
//        }


    </script>
</head>
<body>
@if($customers)




        <form name="myForm" method="post">

            <select name="optionList" id="optionList">
                @foreach($customers as $customer)
                <option value="{{$customer->card_holder}}">{{$customer->card_holder}}</option>
                @endforeach



            </select>


        </form>


    @endif
<div id="divResult">


</div>

</body>
</html>