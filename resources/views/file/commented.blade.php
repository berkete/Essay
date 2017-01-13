
{{--//==========================================first trial--}}

{{--////        $checkout_time=Carbon\Carbon::now();--}}
{{--//        if ($calculations) {--}}
{{--//            foreach ($calculations as $key => $value) {--}}
{{--//                var_dump($value->company);--}}
{{--////                error_log("shume-status:-".$value["status"]."get\n",3,"/Applications/XAMPP/logs/error_log");--}}
{{--////                error_log("shume-company:-".$value["company"]."get\n",3,"/Applications/XAMPP/logs/error_log");--}}
{{--////--}}
{{--//                if ($value->status == '入室' && $value->company == '入側') {--}}
{{--//                    if ($key < $count) {--}}
{{--//                    $x = strtotime(($value->time));--}}
{{--//                    $y = strtotime(next($calculations)->time);--}}
{{--//                    $z = ($y - $x)/3600;--}}
{{--//                    $sumin = $sumin + $z;--}}
{{--//                    //Changing to hours and minutes--}}
{{--//                    $hoursin=floor($sumin);--}}
{{--//                    $minutein=round(60*($sumin-$hoursin));--}}
{{--//                    $sumin=$hoursin;--}}
{{--//                    }--}}
{{--//                }--}}
{{--//                if ($value->status == '退室' && $value->company == '出側') {--}}
{{--//                    if ($key < ($count - 1)) {--}}
{{--////                            var_dump("[IN]");--}}
{{--//                        $a = strtotime(($value->time));--}}
{{--//                        $b = strtotime(next($calculations)->time);--}}
{{--//                        $f = ($b - $a)/3600;--}}
{{--//                        $sumout = ($sumout + $f);--}}
{{--//                        $hoursout=floor($sumout);--}}
{{--//                        $minuteout=round(60*($sumout-$hoursout));--}}
{{--//                        $sumout=$hoursout*(-1);--}}
{{--//--}}
{{--//                    }--}}
{{--//--}}
{{--//                }--}}
{{--//--}}
{{--//--}}
{{--//            }--}}
{{--//--}}


{{--//        }--}}

{{--//        foreach ($displays as $display){--}}
{{--//           $count=count($calculations);--}}
{{--//            foreach ($calculations as $key => $value) {--}}
{{--//                if ($value->status == '入室' && $value->company == '入側' ) {--}}
{{--//                    if ($key < $count) {--}}
{{--////                        var_dump($display->day);--}}
{{--//--}}
{{--//                        //var_dump($value->day);--}}
{{--//                        if ($display->day!==$value->day){--}}
{{--//                            $x = strtotime($value->time);--}}
{{--//                            $y = strtotime($calculations[$key+1]->time);--}}
{{--//                            $z = ($y - $x)/3600;--}}
{{--//                            $sumin = $sumin + $z;--}}
{{--//                            //Changing to hours and minutes--}}
{{--//                            $hoursin=floor($sumin);--}}
{{--//                            $minutein=round(60*($sumin-$hoursin));--}}
{{--//                            $sumin=$hoursin;--}}
{{--//                        }--}}
{{--//--}}
{{--//                    }--}}
{{--//                }--}}
{{--//                if ($value->status == '退室' && $value->company == '出側') {--}}
{{--//                    if ($key < ($count - 1)) {--}}
{{--//                        if ($display->day!==$value->day) {--}}
{{--//                            $a = strtotime(($value->time));--}}
{{--//                            $b = strtotime($calculations[$key + 1]->time);--}}
{{--//                            $f = ($b - $a) / 3600;--}}
{{--//                            $sumout = ($sumout + $f);--}}
{{--//                            $hoursout = floor($sumout);--}}
{{--//                            $minuteout = round(60 * ($sumout - $hoursout));--}}
{{--//--}}
{{--//--}}
{{--//                            $sumout = ($hoursout) * (-1);--}}
{{--//                            //                        var_dump($sumout);--}}
{{--//                        }--}}
{{--//--}}
{{--//                    }--}}
{{--//--}}
{{--//                }--}}
{{--//--}}
{{--//--}}
{{--//            }--}}

{{--//            for ($i=0;$i<$count;$i++){--}}
{{--//                if ($display->status == '入室' && $display->company == '入側') {--}}
{{--//                    if ($i <$count) {--}}
{{--//                        var_dump($calculations[$i+1]->time);--}}
{{--//                        $x = strtotime(($display->time));--}}
{{--//                        $y = strtotime($displays[$i+1]->time);--}}
{{--//--}}
{{--//                        $z = ($y - $x)/3600;--}}
{{--//--}}
{{--//                        $sumin = $sumin + $z;--}}
{{--//--}}
{{--//                        //Changing to hours and minutes--}}
{{--//                        $hoursin=floor($sumin);--}}
{{--//                        $minutein=round(60*($sumin-$hoursin));--}}
{{--//                        $sumin=$hoursin;--}}
{{--//                    }--}}
{{--//                }--}}
{{--//                if ($display->status == '退室' && $display->company == '出側') {--}}
{{--//                    if ($i <=($count - 1)) {--}}
{{--////                            var_dump("[IN]");--}}
{{--//                        $a = strtotime(($display->time));--}}
{{--//                        $b = strtotime(next($display)->time);--}}
{{--//                        $f = ($b - $a)/3600;--}}
{{--//                        $sumout = ($sumout + $f);--}}
{{--//                        $hoursout=floor($sumout);--}}
{{--//                        $minuteout=round(60*($sumout-$hoursout));--}}
{{--//                        $sumout=$hoursout*(-1);--}}
{{--////--}}
{{--//                    }--}}
{{--//--}}
{{--//                }--}}
{{--//--}}
{{--//--}}
{{--//            }--}}


{{--//            $list2[]=array('month'=>$display->month,"day"=>$display->day,"sumin"=>$sumin,"minutein"=>$minutein,"sumout"=>$sumout,"minuteout"=>$minuteout,"enter"=>$display->time,"exit"=>$display->timee);--}}
{{--//        }--}}

{{--//        return response((array)$list2);--}}
{{--//=================================================================first trials--}}
{{--//        $list=array(array('month'=>'month1','days'=>'days1','sumin'=>'sumin1','sumout'=>'sumout1','enter'=>'enter1','exit'=>'exit1'),--}}
{{--//                    array('month'=>'month2','days'=>'days2','sumin'=>'sumin2','sumout'=>'sumout2','enter'=>'enter2','exit'=>'exit2'),--}}
{{--//                    array('month'=>'month3','days'=>'days3','sumin'=>'sumin3','sumout'=>'sumout3','enter'=>'enter3','exit'=>'exit3'),--}}
{{--//                    array('month'=>'month4','days'=>'days4','sumin'=>'sumin4','sumout'=>'sumout4','enter'=>'enter4','exit'=>'exit4'));--}}

{{--//        $list2[]=array('month'=>'septmeber','day'=>'monday','sumin'=>$sin,'sumout'=>$sout,'enter'=>'enter1','exit'=>'exit1');--}}
{{--//        $list2[]=array('month'=>'October','day'=>'tusday','sumin'=>2,'sumout'=>10,'enter'=>'enter2','exit'=>'exit2');--}}
{{--//        $list2[]=array('month'=>'Novemeber','day'=>'wensday','sumin'=>4,'sumout'=>11,'enter'=>'enter3','exit'=>'exit3');--}}
{{--//        $list2[]=array('month'=>'December','day'=>'thursday','sumin'=>5,'sumout'=>12,'enter'=>'enter4','exit'=>'exit4');--}}


{{--//        $arr=[$displays,'sumin'=>$sumin,'sumout'=>$sumout];--}}
{{--//        var_dump($displays);--}}
{{--//        var_dump($a);--}}
{{--//        var_dump($list);--}}

{{--//        echo('<br /><br /><br /><br />------------------<br /><br /><br /><br /><br />');--}}
{{--//        var_dump($list2);--}}


{{--// for try--}}
{{--//        $list=["animal"=>"dog", "plant"=>"flower"];--}}
{{--//        return $list;--}}







{{--//======--}}

{{--===========mylast--}}
{{--//--}}
{{--//        foreach ($displays as $display) {--}}
{{--//            $sumin = 0.0;      // Intializing the time total that the employee stayed in office--}}
{{--//            $sumout = 0.0;--}}
{{--//            foreach ($calculations as $key => $value) {--}}
{{--//--}}
{{--//                echo("<br />------------------------------<br />");--}}
{{--//                var_dump("value-created=:" . $value->created_at);--}}
{{--//                echo("<br />");--}}
{{--//                var_dump("sumin=:".$sumin." , sumout=:".$sumout);--}}
{{--//                echo("<br />------------------------------<br />");--}}
{{--//--}}
{{--//                // reset ( every day )--}}
{{--//                if ($key < ($count-1)) {--}}
{{--//                    if ($value->day !== $calculations[$key + 1]->day) {--}}
{{--//--}}
{{--//                        //        var_dump($valuelist);--}}
{{--//                        $sumin  = 0.0;     // Intializing the time total that the employee stayed in office--}}
{{--//                        $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office--}}
{{--//--}}
{{--//                    }--}}
{{--//                }--}}
{{--//--}}
{{--//                if ($value->status == '入室' && $value->company == '入側') {--}}
{{--//                            if ($key < ($count - 1)) {--}}
{{--//                                if ($value->day == $calculations[$key + 1]->day) {--}}
{{--//                                    $x = strtotime(($value->time));--}}
{{--//                                    $y = strtotime($calculations[$key + 1]->time);--}}
{{--////                            var_dump("x=:".$x);--}}
{{--////                           echo("<br />");--}}
{{--////                            var_dump("y=:".$y);--}}
{{--////                           echo("<br />");--}}
{{--//                                    $z = abs(($y - $x) / 3600);--}}
{{--////                            var_dump("z=:".$z);--}}
{{--////                           echo("<br />");--}}
{{--//                                    $sumin += $z;--}}
{{--////                            var_dump("sumin=:".$sumin);--}}
{{--////                           echo("<br />");--}}
{{--//                                    //Changing to hours and minutes--}}
{{--//                                    $hoursin = floor($sumin);--}}
{{--//                                    $minutein = round(60 * ($sumin - $hoursin));--}}
{{--////                        var_dump("hours in:".$hoursin);--}}
{{--////                        var_dump("minute in:".$minutein);--}}
{{--////                        $sumin = $hoursin;--}}
{{--//--}}
{{--//--}}
{{--//                                }--}}
{{--////                            var_dump();--}}
{{--//--}}
{{--//--}}
{{--//                            }--}}
{{--//--}}
{{--//                        } //                if ($key < ($count-1)&& $calculations[$key]->day!= $display->day ) {--}}
{{--//--}}
{{--//                        if ($key < ($count - 1) && $value->status == '退室' && $value->company == '出側') {--}}
{{--////                            var_dump("[IN]");--}}
{{--//                            if ($key < ($count - 1)) {--}}
{{--//                                if ($value->day == $calculations[$key + 1]->day) {--}}
{{--//                                    $a = strtotime(($value->time));--}}
{{--//                                    $b = strtotime($calculations[$key + 1]->time);--}}
{{--////                          var_dump("a=:" . $a);--}}
{{--////                          echo("<br />");--}}
{{--//--}}
{{--////                          var_dump("b=:" . $b);--}}
{{--//--}}
{{--//                                    $f = abs(($b - $a) / 3600);--}}
{{--////                          var_dump("f=:" . $f);--}}
{{--////                          echo("<br />");--}}
{{--//--}}
{{--//                                    $sumout += $f;--}}
{{--////                          var_dump("sumout=:" . $sumout);--}}
{{--////                          echo("<br />");--}}
{{--//--}}
{{--//                                    $hoursout = floor($sumout);--}}
{{--//                                    $minuteout = round(60 * ($sumout - $hoursout));--}}
{{--////                        var_dump("hours out".$hoursout);--}}
{{--////                    var_dump("minutes out".$minuteout);--}}
{{--////                        $sumout=$hoursout*(-1);--}}
{{--//                                }--}}
{{--//                            }--}}
{{--//--}}
{{--////                    var_dump($valuelist);--}}
{{--//                        }--}}
{{--//--}}
{{--//--}}
{{--//--}}
{{--//                    }--}}
{{--//            $list2[] = array('month' => $display->month, "day" => $display->day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout, "enter" => $display->time, "exit" => $display->timee);--}}
{{--//--}}
{{--//                }--}}
{{--//        return response((array)$list2);--}}
{{--////       $countlist=count($list2);--}}
{{--////        var_dump($countlist);--}}
{{--////       foreach ($list2 as $key=>$list){--}}
{{--////             if($key<($countlist-1)){--}}
{{--////                 if($list['day'])--}}
{{--////--}}
{{--////             }--}}
{{--////           var_dump($list['day']);--}}
{{--//////           if(){--}}
{{--//////--}}
{{--////           }--}}
{{--//--}}
{{--//--}}
{{--//--}}
{{--////        }--}}
{{--//--}}
{{--//--}}
{{--//--}}
{{--//--}}
{{--//    }--}}
{{--//}--}}
{{--//--}}
{{--//==================last--}}


{{--//=======================another trial--}}
{{--//        foreach ($displays as $display) {--}}
{{--//            var_dump($display->day);--}}

{{--//--}}
{{--//            foreach ($calculations as $key => $value) {--}}
{{--////            var_dump($value->month);--}}
{{--////            $valuelist[]=$value->day;--}}
{{--//--}}
{{--////var_dump($value->created_at);--}}
{{--////            echo("<br />");--}}
{{--////            var_dump($value->day ."==". $calculations[$key + 1]->day);--}}
{{--////            echo("<br />"); return response((array)$list2);--}}
{{--////                var_dump("key".$key."=count".$count);--}}
{{--//                if ($key < ($count - 1)) {--}}
{{--//                    $list2[] = array('month' => $value->month, "day" => $value->day, "sumin" => $sumin, "sumout" => $sumout, "enter" => $value->time);--}}
{{--//                    if ($value->day !== $calculations[$key + 1]->day) {--}}
{{--//--}}
{{--//--}}
{{--//                        //        var_dump($valuelist);--}}
{{--//                        $sumin = 0.0;      // Intializing the time total that the employee stayed in office--}}
{{--//                        $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office"exit" => $display->timee--}}
{{--////            $count = count($calculations);--}}
{{--////            $hoursin=0;--}}
{{--////            $hoursout=0;--}}
{{--////            $minuteout=0;--}}
{{--////            $minutein=0;--}}
{{--//--}}
{{--//--}}
{{--//                    }--}}
{{--//--}}
{{--////            var_dump($key);--}}
{{--//--}}
{{--//                        if ($value->status == '入室' && $value->company == '入側') {--}}
{{--//                            if ($key < ($count - 1)) {--}}
{{--//                                if ($value->day == $calculations[$key + 1]->day) {--}}
{{--//                                    $x = strtotime(($value->time));--}}
{{--//                                    $y = strtotime($calculations[$key + 1]->time);--}}
{{--////                            var_dump("x=:".$x);--}}
{{--////                           echo("<br />");--}}
{{--////                            var_dump("y=:".$y);--}}
{{--////                           echo("<br />");--}}
{{--//                                    $z = abs(($y - $x) / 3600);--}}
{{--////                            var_dump("z=:".$z);--}}
{{--////                           echo("<br />");--}}
{{--//                                    $sumin += $z;--}}
{{--////                            var_dump("sumin=:".$sumin);--}}
{{--////                           echo("<br />");--}}
{{--//                                    //Changing to hours and minutes--}}
{{--//                                    $hoursin = floor($sumin);--}}
{{--//                                    $minutein = round(60 * ($sumin - $hoursin));--}}
{{--////                        var_dump("hours in:".$hoursin);--}}
{{--////                        var_dump("minute in:".$minutein);--}}
{{--////                        $sumin = $hoursin;--}}
{{--//--}}
{{--//--}}
{{--//                                }--}}
{{--////                            var_dump();--}}
{{--//--}}
{{--//--}}
{{--//                            }--}}
{{--//--}}
{{--//                        } //                if ($key < ($count-1)&& $calculations[$key]->day!= $display->day ) {--}}
{{--//--}}
{{--//                        if ($key < ($count - 1) && $value->status == '退室' && $value->company == '出側') {--}}
{{--////                            var_dump("[IN]");--}}
{{--//                            if ($key < ($count - 1)) {--}}
{{--//                                if ($value->day == $calculations[$key + 1]->day) {--}}
{{--//                                    $a = strtotime(($value->time));--}}
{{--//                                    $b = strtotime($calculations[$key + 1]->time);--}}
{{--////                          var_dump("a=:" . $a);--}}
{{--////                          echo("<br />");--}}
{{--//--}}
{{--////                          var_dump("b=:" . $b);--}}
{{--//--}}
{{--//                                    $f = abs(($b - $a) / 3600);--}}
{{--////                          var_dump("f=:" . $f);--}}
{{--////                          echo("<br />");--}}
{{--//--}}
{{--//                                    $sumout += $f;--}}
{{--////                          var_dump("sumout=:" . $sumout);--}}
{{--////                          echo("<br />");--}}
{{--//--}}
{{--//                                    $hoursout = floor($sumout);--}}
{{--//                                    $minuteout = round(60 * ($sumout - $hoursout));--}}
{{--////                        var_dump("hours out".$hoursout);--}}
{{--////                    var_dump("minutes out".$minuteout);--}}
{{--////                        $sumout=$hoursout*(-1);--}}
{{--//                                }--}}
{{--//                            }--}}
{{--//--}}
{{--////                    var_dump($valuelist);--}}
{{--//                        }--}}
{{--//--}}
{{--//--}}
{{--//                    }--}}
{{--//                }--}}
{{--////       $countlist=count($list2);--}}
{{--////        var_dump($countlist);--}}
{{--////       foreach ($list2 as $key=>$list){--}}
{{--////             if($key<($countlist-1)){--}}
{{--////                 if($list['day'])--}}
{{--////--}}
{{--////             }--}}
{{--////           var_dump($list['day']);--}}
{{--//////           if(){--}}
{{--//////--}}
{{--////           }--}}
{{--//        return response((array)$list2);--}}
{{--//--}}
{{--//--}}
{{--////        }--}}
{{--//    }--}}
{{--//}--}}

{{--//=======================another trial--}}

{{--======================================working--}}
{{--public function display()--}}
{{--{--}}
{{--$yearInput = Input::get('year');--}}
{{--$monthInput = Input::get('month');--}}
{{--$nameInput = Input::get('name');--}}
{{--// Database data with specific days(group by day)--}}
{{--$displays = DB::table('customers')--}}
{{--->select(DB::raw('day(created_at) as day,Month(created_at) as month,time(created_at)as time,MAX(time(created_at))as timee,card_holder,status,company'))--}}
{{--->whereRaw('year(created_at) =?', [$yearInput])--}}
{{--->whereRaw(('month(created_at) =?'), [$monthInput])--}}
{{--->whereRaw(('card_holder like ?'), [$nameInput])--}}
{{--->groupBy('day')->get();--}}
{{--// database data for calculation  for each date--}}
{{--$calculations = DB::table('customers')--}}
{{--->select(DB::raw('created_at,time(created_at) as time,day(created_at) as day,month(created_at) as month,status,company'))--}}
{{--->whereRaw('year(created_at) =?', [$yearInput])--}}
{{--->whereRaw(('month(created_at) =?'), [$monthInput])--}}
{{--->whereRaw(('card_holder like ?'), [$nameInput])--}}
{{--->orderBy('created_at', 'asc')--}}
{{--->get();--}}

{{--////        error_log("shume2:-".$calculations."get\n",3,"/Applications/XAMPP/logs/error_log");--}}
{{--$sumin = 0.0;      // Intializing the time total that the employee stayed in office--}}
{{--$sumout = 0.0;     // Intializing the time total that the employee stayed outside the office--}}
{{--$count = count($calculations);--}}
{{--$displaylist = [];--}}
{{--$valuelist = [];--}}

{{--//=================================better work  "minutein"=>$minutein,"minuteout"=>$minuteout,--}}
{{--//--}}
{{--//        foreach ($displays as $display) {--}}
{{--$sumin = 0.0;      // Intializing the time total that the employee stayed in office--}}
{{--$sumout = 0.0;--}}
{{--foreach ($calculations as $key => $value) {--}}

{{--//                echo("<br />------------------------------<br />");--}}
{{--//                var_dump("value-created=:" . $value->created_at);--}}
{{--//                echo("<br />");--}}
{{--//                var_dump("sumin=:".$sumin." , sumout=:".$sumout);--}}
{{--//                echo("<br />------------------------------<br />");--}}

{{--// reset ( every day )--}}
{{--if ($key < ($count-1)) {--}}
{{--if ($value->day !== $calculations[$key + 1]->day) {--}}

{{--//                        $list2[] = array('month' => $value->month, "day" => $value->day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout, "enter" => $display->time, "exit" => $display->timee);--}}
{{--$list2[] = array('month' => $value->month, "day" => $value->day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout,);--}}


{{--//        var_dump($valuelist);--}}
{{--$sumin  = 0.0;     // Intializing the time total that the employee stayed in office--}}
{{--$sumout = 0.0;     // Intializing the time total that the employee stayed outside the office--}}


{{--$minutein=0.0;--}}
{{--$minuteout=0.0;--}}
{{--}--}}
{{--}--}}
{{--//                var_dump($display->day);--}}

{{--if ($value->day == $calculations[$key]->day) {--}}
{{--if ($value->status == '入室' && $value->company == '入側') {--}}
{{--if ($key < ($count - 1)) {--}}
{{--//                            var_dump($count);--}}
{{--$x = strtotime(($value->time));--}}
{{--$y = strtotime($calculations[$key + 1]->time);--}}
{{--//                        var_dump("x=:".$x);--}}
{{--//                        var_dump("y=:".$y);--}}
{{--$z = ($y - $x) / 3600;--}}
{{--//                        var_dump("z=:".$z);--}}
{{--$sumin += $z;--}}
{{--//                        var_dump("sumin=:".$sumin);--}}
{{--//Changing to hours and minutes--}}
{{--$hoursin = floor($sumin);--}}
{{--$minutein = round(60 * ($sumin - $hoursin));--}}
{{--//                        var_dump("hours in:".$hoursin);--}}
{{--//                        var_dump("minute in:".$minutein);--}}
{{--//                        $sumin = $hoursin;--}}

{{--}--}}

{{--}--}}
{{--}--}}


{{--//                if ($key < ($count-1)&& $calculations[$key]->day!= $display->day ) {--}}
{{--if ($value->day == $calculations[$key]->day) {--}}
{{--if ($value->status == '退室' && $value->company == '出側') {--}}
{{--//                            var_dump("[IN]");--}}
{{--if($key < ($count - 1) ){--}}
{{--$a = strtotime(($value->time));--}}
{{--$b = strtotime($calculations[$key + 1]->time);--}}
{{--//                            var_dump("a=:" . $a);--}}
{{--//                            echo("<br />");--}}
{{--//                            var_dump("b=:" . $b);--}}
{{--//                            echo("<br />");--}}
{{--//                            var_dump("value-created=:" . $value->created_at);--}}
{{--//                            echo("<br />");--}}
{{--//                            var_dump("calculations-created=:" . $calculations[$key + 1]->created_at);--}}
{{--//                            echo("<br />");--}}
{{--//                            $f=0.0;--}}
{{--if ($value->day == $calculations[$key + 1]->day) {--}}


{{--$f = ($b - $a) / 3600;--}}
{{--}--}}
{{--//                            var_dump("f=:" . $f);--}}
{{--//                            echo("<br />");--}}
{{--//                            echo("<br />");--}}
{{--$sumout += $f;--}}
{{--//                            var_dump("sumout=:" . $sumout);--}}
{{--$hoursout = floor($sumout);--}}
{{--//                            var_dump($hoursout);--}}
{{--$minuteout = round(60 * ($sumout - $hoursout));--}}
{{--//                        var_dump("hours out".$hoursout);--}}
{{--//                        $sumout=$hoursout*(-1);--}}
{{--}--}}
{{--}--}}
{{--}--}}
{{--//--}}
{{--$last_month=$value->month;--}}
{{--$last_day=$value->day;--}}


{{--}--}}
{{--//        }--}}

{{--// only last data--}}
{{--$list2[] = array('month' => $last_month, "day" => $last_day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout);--}}

{{--//        echo("<br />------------------------------<br />");--}}
{{--//        var_dump($list2);--}}
{{--//        echo("<br />------------------------------<br />");--}}

{{--return response((array)$list2);--}}

{{--}--}}
{{--}--}}
{{--//===============================================better works--}}



