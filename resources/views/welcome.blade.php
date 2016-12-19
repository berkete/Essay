
@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>

    <body>
    {{--@section('content')--}}
        <div class="container">
            <div class="row">

                <div class="page-header">



                </div>


        <div class="row">
            <form name="myForm" method="post">
            <div class="col-sm-4">

                <select name="optionList" id="optionList">
                    @foreach($customers as $customer)
                        <option value="{{$customer}}">{{$customer}}</option>
                @endforeach
                </select>
            </div>
            <div class="col-sm-4">

                <select name="optionList2" id="optionList2">
                    @foreach($customers2 as $customer)
                        <option value="{{$customer}}">{{$customer}}</option>
                @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                <select name="optionList3" id="optionList4" multiple>
                    @foreach($customers4 as $customer)
                        <option value="{{$customer}}">{{$customer}}</option>
                    @endforeach



                </select>

            </div>
            </form>
        </div>














                <form action="/searchs2">
                    <div class="form-group">
                        <label for=""></label>

                        {{--<input type="text" class="form-control input-sm">--}}

                    </div>


                    <div class="form-group">
                        <label for=""> </label>

                        {{--<input type="text" class="form-control input-sm">--}}

                    </div>
                     <div class="form-group customer-select-container">

                        <label for=""></label>
                         {{--{{Form::select('customers',$customers,null,['class'=>'input-sm'])}}--}}


                         {{--@if($customers=='selected')--}}

                             {{--@foreach($customers as $customer)--}}

                                 {{--<ul>--}}


                                     {{--<li>--}}

                                         {{--{{$customer}}--}}

                                     {{--</li>--}}
                                 {{--</ul>--}}

                                 {{--@endforeach--}}


                             {{--@endif--}}
                         {{--<a href="" class="btn btn-xs btn-danger btn-remove">Remove</a>--}}
                     </div>
                    <div class="form-group customer-select-container2">

                        <label for=""></label>
                        {{--{{Form::select('customers[]',$customers2,null,['class'=>'input-sm'])}}--}}
                        <a href="" class="btn btn-xs btn-danger btn-remove"></a>
                        </div>
                    <a href="" class="btn btn-sm btn-info btn-add-more-customers1">+Name</a>
                    <a href="" class="btn btn-sm btn-info btn-add-more-customers">+year</a>
                    <a href="" class="btn btn-sm btn-info btn-add-more-customers2">+Date and Month</a>
                    <div class="col-sm-3">
                <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>

                    </div>
                </form>
            </div>
            <div id="campaign">
                {{--{{\Illuminate\Support\Facades\Input::get('customers')}}--}}
            </div>

            <table class="table">
                <thead>
                  <tr>
                    <th>生い　</th>
                    <th> とし　</th>
                    <th>月</th>
                      <th>in</th>
                      <th>out</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="info">
                    <td><div class="col-sm-6" id="name">

                            <h3>name</h3>

                        </div></td>
                    <td><div class="col-sm-1" id="year">
                            <h3>year</h3>

                        </div></td>
                    <td> <div class="col-sm-2" id="month">

                            <h3>month</h3>

                        </div>
                        </td>
                      <td> <div class="col-sm-1" id="month">

                              <h3>IN</h3>

                          </div>
                      </td>
                      <td> <div class="col-sm-1" id="month">

                              <h3>OUT</h3>

                          </div>
                      </td>
                  </tr>

                </tbody>
              </table>
          <div class="row">






          </div>
            <div id="divResult">
                {{--<h1>display here</h1>--}}

            </div>

        </div>




        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>

            var template='<div class="col-sm-4 customer-select-container">'+

                    '<label for="">名前　</label>'+
                    '{{Form::select('customers',[''=>'Select name']+$customers,null,['class'=>'input-sm'])}}'+

                    '</div>';



            var x='<div class="col-sm-4 customer-select-container2">'+

                    '<label for=""> とし</label>'+
                    '{{Form::select('customers2',[''=>'Select year']+$customers2,null,['class'=>'input-sm'])}}'+

                    '</div>';

            var y='<div class="col-sm-4 customer-select-container2">'+

                    '<label for="">月　</label>'+
                    '{{Form::select('customers4',[''=>'Select date and month ']+$customers4,null,['class'=>'input-sm'])}}'+
                    '<a href="" class="btn btn-xs btn-danger btn-remove">Remove</a>'+
                    '</div>';
            var z=' <div class="col-sm-3">'+
                    '<span class="input-group-btn">'+
                    '<button type="submit" class="btn btn-default">'+
                    '<span class="glyphicon glyphicon-search"></span>'+
                    '</button>'+
                    '</span>'+'</div>';



                    $(document).ready(function () {
                        $('#optionList').change(function () {

                            var selectedOption=$('#optionList option:selected');
                            console.log(selectedOption);
                            $('#name').html(selectedOption.text())+'<br>';

                        });

                    });
                    $(document).ready(function () {
                        $('#optionList2').change(function () {

                            var selectedOption=$('#optionList2 option:selected');
                            console.log(selectedOption);
                            $('#year').html(selectedOption.text());

                        });

                    });
                    $(document).ready(function () {
                        $('#optionList4').change(function () {

                            var selectedOption=$('#optionList4 option:selected');
                            console.log(selectedOption);
                            $('#month').html(selectedOption.text()+'\n');


                        });

                    });

            //        function handleSelect(myForm) {
            //            var x=myForm.optionList.options[myForm.selectedIndex];
            //            alert(x);
            //
            //
            //        }





            $('.btn-add-more-customers1').on('click',function (e) {
                e.preventDefault();

                $(this).before(template);
                $(this).hide(template);

            });
            $('.btn-add-more-customers').on('click',function (e) {
                e.preventDefault();
                $(this).before(x);
                $(this).hide(x);

            });
            $('.btn-add-more-customers2').on('click',function (e) {
                e.preventDefault();
                $(this).after(z);
                $(this).before(y);
                $(this).hide(y);



            });

            $(document).on('click','btn-remove',function (e) {

                e.preventDefault();
                $(this).parents('.customer-select-container'|| '.customer-select-container2').remove();

            });
//            $('.customer-select-container').on('change',function (e) {
//
//                var i=0;
//                for (;i<5;i++){
//
//                    var target = $('#customers[i]:selected').val();
//                    if(target==$customers){
//                        $(this).show(target);
//
//                    }}
//
//
//
//                });


        </script>

    </body>
</html>

@endsection