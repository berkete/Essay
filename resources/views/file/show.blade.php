@extends('layouts.app')



@section('content')

    @if($items)

    <select id="userselect" name="userselect">
        <option>Select User</option>
        @foreach ($items as $user)
           {{ var_dump($user->id)}}
            <option value="{{ $user->id }}">{{ $user->card_holder}}</option>
        @endforeach
    </select>

    <select id="itemselect" name="itemselect">
        <option>Please choose user first</option>
    </select>




@endif

    @endsection

@section('script')
<script>
    jQuery(document).ready(function($){
        $('#userselect').change(function() {
            $.get("{{ url('myurl')}}", {option: $(this).val()}, function (data) {
                var item = $('#itemselect');
                item.empty();
                $.each(data, function (key, value) {
                    item.append("<option value='" + value.id + "'>" + value.name + "</option>");
                });
            });
        });
    });
</script>
    @endsection



{{--from test blade


{{--@extends('layouts.app')--}}

{{--@section('content')--}}

{{--<table class="table" style="width: 80%;margin-top: 45px">--}}
{{--<thead>--}}
{{--<tr>--}}
{{--<th>日</th>--}}
{{--<th>IN</th>--}}
{{--<th>OUT</th>--}}
{{--<th>出社</th>--}}
{{--<th>退社</th>--}}
{{--</tr>--}}
{{--</thead>--}}

{{--<?php--}}


{{--$sumin=0;$sumout=0;--}}

{{--$enterance_time;    // Enterance time--}}
{{--$exit_time;    // Exit time--}}
{{--$month_day;   // Display month and day--}}

{{--// --------------------------------------------------------------}}
{{--// uchida test--}}
{{--// --------------------------------------------------------------}}
{{--$count=count($details);--}}
{{--var_dump($details);--}}
{{--if ($details!==null){--}}
{{--foreach($details as $key => $value){--}}


{{--//                var_dump( "KEY: ".$key."<br />");--}}
{{--////                var_dump( "created_at: ". $value["created_at"] ."<br />");--}}
{{--//                var_dump( "card_number: ". $value["card_number"] ."<br />");--}}
{{--//                var_dump( "card_holder: ". $value["card_holder"] ."<br />");--}}
{{--//                var_dump( "------------------------------<br />");--}}
{{--if ($value["status"]=='入室' && $value["company"]=='入側' && $value!==null){--}}
{{--//                        var_dump("--------<br />");--}}
{{--//                        var_dump("key=".$key.", count=".$count);--}}
{{--if ($key<$count){--}}
{{--$x=strtotime(($value["created_at"]));--}}
{{--//                            var_dump($x);--}}
{{--$y=strtotime($details[$key+1]["created_at"]);--}}

{{--$z=($y-$x)/3600;--}}

{{--$sumin=$sumin+$z;--}}
{{--}--}}
{{--}--}}

{{--elseif ($value["status"]=='退室' && $value["company"]=='出側'){--}}
{{--//                        $a=\Carbon\Carbon::parse($value["created_at"])->format('h:i:s');--}}
{{--//                        $b=\Carbon\Carbon::parse($details[$key+1]["created_at"])->format('h:i:s');--}}
{{--if ($key<($count-1)){--}}
{{--//                            var_dump("[IN]");--}}
{{--$a=strtotime(($value["created_at"]));--}}
{{--$b=strtotime($details[$key+1]["created_at"]);--}}
{{--$z=($b-$a)/3600;--}}
{{--$sumout=$sumout+$z;--}}
{{--//                            var_dump("---sumout-----".$sumout);--}}
{{--}--}}
{{--//                        var_dump("--------<br />");--}}
{{--}--}}

{{--$month_day=\Carbon\Carbon::parse($value->created_at)->format('M/d');--}}

{{--if ($key==0){--}}

{{--$enterance_time= \Carbon\Carbon::parse($value->created_at)->format('H:i:s');--}}
{{--//                      echo "<br>Enterance time".$h;--}}
{{--}--}}

{{--if($key==($count-1)){--}}
{{--$exit_time=\Carbon\Carbon::parse($value->created_at)->format('H:i:s');--}}
{{--//                   echo "<br>Office leave at".$g;--}}

{{--}--}}
{{--var_dump($key."==(".$count."-1)");--}}


{{--} //foreach end--}}
{{--// --------------------------------------------------------------}}

{{--//            if(isset($details)){--}}
{{--//                foreach($details  as $customer){--}}
{{--//                echo '<tr class="info">';--}}
{{--//                echo "<td>$customer->card_holder</td>";--}}
{{--//                echo "<td>$customer->card_number</td>--}}
{{--//                    <td>$customer->status</td>--}}
{{--//                    <td>$customer->company</td>--}}
{{--//                    <td>$customer->created_at</td></tr>";--}}
{{--//                    for($i=0;$i<count($customer);$i++){--}}
{{--//                if ($customer->status=='入室' && $customer->company=='入側' || $customer->card_number[$i]==$customer->card_number[$i+1]){--}}
{{--// this data--}}
{{--//                    $z= \Carbon\Carbon::parse($customer->created_at)->format('h:i:s');--}}
{{--//                    $date=strtotime($z,time());--}}
{{--//                    echo"<td>$customer->created_at</td>";--}}
{{--//--}}
{{--//                }--}}

{{--//                elseif ($customer->status=='退室' && $customer->company=='出側' || $customer->card_number[$i]==$customer->card_holder[$i+1]){--}}
{{--//                    $t= \Carbon\Carbon::parse($customer->created_at)->format('h:i:s');--}}
{{--//                    $y=$customer->created_at[$i]-$customer->created_at[$i+1];--}}
{{--//                    $date2=strtotime($t);--}}
{{--////                    echo "<td>".$date2."</td>";--}}
{{--////                    $sumout=$sumout+$y;--}}
{{--////                    var_dump($t);--}}
{{--//                    if ($customer->card_number[$i]!=$customer->card_number[$i+1]){--}}
{{--//--}}
{{--//                        continue;--}}
{{--//                    }--}}
{{--//--}}
{{--//                }}--}}
{{--//                    }--}}


{{--//                }--}}

{{--$timein=$sumin;--}}
{{--$timeout=$sumout;--}}
{{--$hoursout=floor($timeout);--}}
{{--$hours=floor($timein);--}}
{{--$minuteout=round(60*($timeout-$hoursout));--}}
{{--$minutein=round(60*($timein-$hours));--}}
{{--echo "<tr class='success'><td>$month_day</td><td style='caption-side: bottom;color: blue'>  $hours 時　と  $minutein 分　</td>--}}
{{--<td style='caption-side: bottom;color: blue'> $hoursout  時　と　 $minuteout 分　 </td>--}}
{{--<td style='caption-side: bottom;color: blue'>$enterance_time</td><td style='caption-side: bottom;color: blue'>$exit_time</td><td></td></tr>";--}}
{{--}--}}

{{--?>--}}

{{--</table>--}}
{{--<h1>Search page</h1>--}}
{{--@endsection--}}



{{--After isset if function


//            foreach($details  as $customer){
//                echo '<tr class="info">';
//                echo "<td>$customer->card_holder</td>";
//                echo "<td>$customer->card_number</td>
//                    <td>$customer->status</td>
//                    <td>$customer->company</td>
//                    <td>$customer->created_at</td></tr>";
//                    for($i=0;$i<count($customer);$i++){
//                if ($customer->status=='入室' && $customer->company=='入側' || $customer->card_number[$i]==$customer->card_number[$i+1]){
                // this data
//                    $z= \Carbon\Carbon::parse($customer->created_at)->format('h:i:s');
//                    $date=strtotime($z,time());
//                    echo"<td>$customer->created_at</td>";
//
//                }

//                elseif ($customer->status=='退室' && $customer->company=='出側' || $customer->card_number[$i]==$customer->card_holder[$i+1]){
//                    $t= \Carbon\Carbon::parse($customer->created_at)->format('h:i:s');
//                    $y=$customer->created_at[$i]-$customer->created_at[$i+1];
//                    $date2=strtotime($t);
////                    echo "<td>".$date2."</td>";
////                    $sumout=$sumout+$y;
////                    var_dump($t);
//                    if ($customer->card_number[$i]!=$customer->card_number[$i+1]){
//
//                        continue;
//                    }
//
//                }}
//                    }


//            }--}}




{{--//                var_dump( "KEY: ".$key."<br />");--}}
{{--////                var_dump( "created_at: ". $value["created_at"] ."<br />");--}}
{{--//                var_dump( "card_number: ". $value["card_number"] ."<br />");--}}
{{--//                var_dump( "card_holder: ". $value["card_holder"] ."<br />");--}}
{{--//                var_dump( "------------------------------<br />");--}}