@extends('layouts.app')

@section('content')

    <table class="table" style="width: 80%">
        <thead>
        <tr>
            {{--<th>Name</th>--}}
            <th>日</th>
            <th>IN</th>
            <th>OUT</th>
            <th>出社</th>
            <th>退社</th>

        </tr>
        </thead>

        <?php


        $sumin=0;      // Intializing the time total that the employee stayed in office
        $sumout=0;     // Intializing the time total that the employee stayed outside the office
        $count=count($details);
        if ($details!==null){
            foreach($details as $key => $value){
                if ($value["status"]=='入室' && $value["company"]=='入側' && $value!==null){
//                        var_dump("--------<br />");
//                        var_dump("key=".$key.", count=".$count);
                    if ($key<$count){
                        $x=strtotime(($value["created_at"]));
//                            var_dump($x);
                        $y=strtotime($details[$key+1]["created_at"]);

                        $z=($y-$x)/3600;

                        $sumin=$sumin+$z;
                    }
                }
                if ($value["status"]=='退室' && $value["company"]=='出側'){
                    if ($key<($count-1)){
//                            var_dump("[IN]");
                        $a=strtotime(($value["created_at"]));
                        $b=strtotime($details[$key+1]["created_at"]);
                        $z=($b-$a)/3600;
                        $sumout=$sumout+$z;
                    }
                }
                $month_day=\Carbon\Carbon::parse($value->created_at)->format('M/d');
                // Used to select the first and the last time
                if ($key==0){
                    $enterance_time= \Carbon\Carbon::parse($value->created_at)->format('H:i:s');
                }
                 if($key==$count-1){
                    $checkout_time=\Carbon\Carbon::parse($value->created_at)->format('H:i:s');
                 }

            }
            $timein=$sumin;
            $timeout=$sumout;
            $hoursout=floor($timeout);
            $hours=floor($timein);
            $minuteout=round(60*($timeout-$hoursout));
            $minutein=round(60*($timein-$hours));

            echo "<tr><td>$month_day</td><td style='caption-side: bottom;color: blue'> $hours 時　と  $minutein 分</td>
                      <td style='caption-side: bottom;color: blue'>$hoursout 時　と  and $minuteout 分 </td>
                      <td style='caption-side: bottom;color: blue'>  $enterance_time</td>
                      <td style='caption-side: bottom;color: blue'>  $checkout_time</td><td></td></tr>";
        }

        ?>

    </table>
    {{--<h1>Search page</h1>--}}
@endsection





