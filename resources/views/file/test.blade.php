@extends('layouts.app')

@section('content')

        <table class="table" style="width: 80%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Card number</th>
                <th>status</th>
                <th>status2</th>
                <th>Date</th>
                <th>stayed</th>
            </tr>
            </thead>

            <?php


            $sumin=0;$sumout=0;$h;$g;

            // ------------------------------------------------------------
            // uchida test
            // ------------------------------------------------------------
            $count=count($details);
//            var_dump($count);
            if ($details!==null){
            foreach($details as $key => $value){


//                var_dump( "KEY: ".$key."<br />");
////                var_dump( "created_at: ". $value["created_at"] ."<br />");
//                var_dump( "card_number: ". $value["card_number"] ."<br />");
//                var_dump( "card_holder: ". $value["card_holder"] ."<br />");
//                var_dump( "------------------------------<br />");
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

                    elseif ($value["status"]=='退室' && $value["company"]=='出側'){
//                        $a=\Carbon\Carbon::parse($value["created_at"])->format('h:i:s');
//                        $b=\Carbon\Carbon::parse($details[$key+1]["created_at"])->format('h:i:s');
                        if ($key<($count-1)){
//                            var_dump("[IN]");
                            $a=strtotime(($value["created_at"]));
                            $b=strtotime($details[$key+1]["created_at"]);
                            $z=($b-$a)/3600;
                            $sumout=$sumout+$z;
//                            var_dump("---sumout-----".$sumout);
                        }
//                        var_dump("--------<br />");
                    }

                if ($key==0){

                    $h= $value["created_at"];
                    echo "<br>Enterance time".$h;
                }

                elseif($key==$count-1){
                    $g=$value["created_at"];
                    echo "<br>Office leave at".$g;

                }

                    }
            }
            // ------------------------------------------------------------

            if(isset($details)){
                foreach($details  as $customer){
                echo '<tr class="info">';
                echo "<td>$customer->card_holder</td>";
                echo "<td>$customer->card_number</td>
                    <td>$customer->status</td>
                    <td>$customer->company</td>
                    <td>$customer->created_at</td></tr>";
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


                }

                $timein=$sumin;
                $timeout=$sumout;
                $hoursout=floor($timeout);
                $hours=floor($timein);
                $minuteout=round(60*($timeout-$hoursout));
                $minutein=round(60*($timein-$hours));

                echo "<tr><td style='caption-side: bottom;color: blue'> Stayed in office $hours hours and $minutein minutes</td>
                      <td style='caption-side: bottom;color: blue'> outside the office $hoursout hours   and $minuteout minutes </td>
                      <td style='caption-side: bottom;color: blue'> Enterance time $h</td><td style='caption-side: bottom;color: blue'> check out time$g</td><td></td></tr>";
                }

            ?>

        </table>
    {{--<h1>Search page</h1>--}}
@endsection