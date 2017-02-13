$enter_time=0;
$avg_enterance_hour1=0.0;
$avg_enterance_minute1=0.0;
$avg_enterance_second1=0.0;
$avg_enterance_hour=0.0;
$avg_enterance_minute=0.0;
$avg_enterance_second=0.0;
$average_exit=0;
//        $average_enterance=0;
$count2=0;

foreach ($calculations as $key => $value) {

//            var_dump($value);

if ($everyday_first_data_flg === 1) {
//                echo("time1:");
//                var_dump($value->time);
//                echo("<br /><br />");
}

if ($everyday_first_data_flg === 1 && $value->card_holder==$calculations[$key]->card_holder) {
//echo("time2:");
//                var_dump($value->card_holder);
//                var_dump($value->time);
//                echo("<br /><br />");
$enter_time=$value->time;
$a      = preg_split('/[: ]/', $enter_time);
$count2++;
$hour   = $a[0];
$minute = $a[1];
$second   = $a[2];
if($hour<=10){
$avg_enterance_hour=$avg_enterance_hour+$hour;
$avg_enterance_minute=$avg_enterance_minute+$minute;
$avg_enterance_second=$avg_enterance_second+$second;
}
else{
$count2--;
$minute=0;
$second=0;
}

$average_hour=floor($avg_enterance_hour/$count2);

$average_minute=floor($avg_enterance_minute/$count2);
$average_second=floor($avg_enterance_second/$count2);

if($average_minute>=59){
$average_hour=$average_hour+1.0;
$average_minute=$average_minute-60.0;
}
if ($average_second>=59){
$average_minute=$average_minute+1.0;
$average_second=$average_second-60.0;
}
$average_enterance=$average_hour.":".$average_minute.":".$average_second;
//               / var_dump($average_enterance);

//                var_dump($enter_time);
//                $enter_time = (strtotime($value->time)+$enter_time)/($count*3600);

//$everyday_first_data_flg = 0;
}
// reset ( every day )

elseif ($value->day !== $calculations[$key + 1]->day) {

//                    echo("<br /><br />====CHANGE DAY!!!2====<br />");
if ($value->card_holder==$calculations[$key+1]->card_holder) {
$exit_time = $value->time;
var_dump($exit_time);
echo "<br>";

$b = preg_split('/[: ]/', $exit_time);
$count2++;
$hour = $b[0];
$minute = $b[1];
$second = $b[2];
$avg_enterance_hour1 = $avg_enterance_hour1 + $hour;
$avg_enterance_minute1 = $avg_enterance_minute1 + $minute;
$avg_enterance_second1 = $avg_enterance_second1 + $second;
}
else{
$avg_enterance_hour = 0.0;
$avg_enterance_minute1 = 0.0;
$avg_enterance_second1 = 0.0;
}
}





//                    var_dump($value->day);
//                    var_dump($value->time);
//                    var_dump($value->card_holder);
//                    echo("<br />");
//                    var_dump($calculations[$key + 1]->day);
//                    var_dump($calculations[$key + 1]->time);
//                    var_dump($calculations[$key + 1]->card_holder);

//                }
//                else{
//
////                    $everyday_first_data_flg = 0;
////                    echo("<br />====NOT CHANGE DAY!!!====<br /><br />");
//                }

if ($value->card_number== $calculations[$key]->card_number) {
if ($value->day!==$calculations[$key + 1]->day && $everyday_first_data_flg===1){
$exit_time=$value->time;
//                        var_dump($value->time);
//                        var_dump($value->card_holder);
//                        echo "<br>";







//$everyday_first_data_flg=1;
}
if($value->card_number==$calculations[$key+1]->card_number && $everyday_first_data_flg===1){
//                        $exit_time=$value->time;

//                        if ($value->day==$calculations[$key]->day){
//                            $exit_time=$value->time;
//                        echo("exit time:");
//                            var_dump($exit_time);
//                            var_dump($value->card_number);
//                        echo("<br />");
//                            echo "<br>";


//                        var_dump($average_exit);
//                        echo "<br>";

//                        echo "<br>";
//                        var_dump($value->card_number);
//                        echo "<br>";



$everyday_first_data_flg=0;
}



}
