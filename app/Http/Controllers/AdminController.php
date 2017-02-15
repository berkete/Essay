<?php

namespace App\Http\Controllers;
use App\Customer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
          // Used to select year in the display list
        $users = Customer::paginate(20);
        $years = DB::table('customers')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->groupBy("year")
            ->orderBy("year","desc")
            ->get();
         // used to select months in the display list
        $months = DB::table('customers')
            ->select(DB::raw('MONTH(created_at) as month'))
            ->orderBy("month","asc")
            ->get();
        return view('file.index', compact('users','years','months'));
    }
    public function view_list(){
        // used to send ajax response to the index blade
        $yearInput = Input::get('year');
        $monthInput = Input::get('month');
        $views = DB::table('customers')
            ->select(DB::raw('created_at,year(created_at) as year,month(created_at) as month,card_holder,door,status,company,company2,status2,card_number'))
            ->whereRaw('year(created_at) =?', [$yearInput])
            ->whereRaw(('month(created_at) =?'), [$monthInput])
            ->orderBy('created_at', 'asc')
            ->get();
        $list2=array();
        foreach ($views as $view){
            $list2[] = array("dates" => $view->created_at, "door" => $view->door,"status" => $view->status, "company" => $view->company,"status2"=>$view->status2,"company2"=>$view->company2,"card_number"=>$view->card_number,
                "card_holder"=>$view->card_holder);
        }
        return response($list2);

    }
    public function daily_report(){
        $daily_years = DB::table('customers')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->groupBy("year")
            ->orderBy("year","desc")
            ->get();
       return view('file.daily',compact('daily_years'));

    }
    public function total_name(){
        {
            // Used to select year in the display list
            $users = Customer::paginate(50);
            $years = DB::table('customers')
                ->select(DB::raw('YEAR(created_at) as year'))
                ->groupBy("year")
                ->orderBy("year",'desc')
                ->get();
            // used to select months in the display list
            $card_holders = DB::table('customers')
                ->select(DB::raw('card_holder','card_number'))
                ->groupBy("card_number")
                ->get();
            return view('file.one_year', compact('users','years','card_holders'));
        }
    }
    public function total_name_list(){
        // used to send ajax response to the one_year blade
        $yearInput = Input::get('year');
        $calculations = DB::table('customers')
            ->select(DB::raw('created_at,time(created_at) as time,day(created_at) as day,month(created_at) as month,card_holder,card_number,status,company'))
            ->whereRaw('year(created_at) =?', [$yearInput])
            ->orderBy('card_number', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
        $sumin = 0.0;      // Intializing the time total that the employee stayed in office
        $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
        $count = count($calculations);
        $displaylist = [];
        $valuelist = [];
        $everyday_first_data_flg=1;
        $sumin = 0.0;      // Intializing the time total that the employee stayed in office
        $sumout = 0.0;
        foreach ($calculations as $key => $value) {
            if($everyday_first_data_flg===1) {
                $enter_time=$value->time;

                $everyday_first_data_flg = 0;
            }
            // reset ( every day )
            if ($key < ($count-1)) {
                if ($value->day !== $calculations[$key + 1]->day && $value->card_number !== $calculations[$key + 1]->card_number) {
                    $list2[] = array('month' => $value->month,'card_number' => $value->card_number, 'card_holder' => $value->card_holder, "day" => $value->day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout, "enter" => $enter_time, "exit" => $calculations[$key]->time);
                    $everyday_first_data_flg = 1;
                    //        var_dump($valuelist);
                    $sumin = 0.0;     // Intializing the time total that the employee stayed in office
                    $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
                    $minutein = 0.0;
                    $minuteout = 0.0;
                }
                if ($value->month == $calculations[$key+1]->month && $value->card_number == $calculations[$key+1]->card_number && $value->card_holder !== "未登録カード") {
                    if ($value->status == '入室' && $value->company == '入側') {
//                        var_dump("ok3");
                        if ($key < ($count - 1)) {
                            $x = strtotime(($value->time));
                            $y = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                $z = ($y - $x) / 3600;
                            }
                            $sumin += $z;
                            $hoursin = floor($sumin);
                            $minutein = round(60 * ($sumin - $hoursin));
                            if ($minutein > 59) {
                                $hoursin = $hoursin + 1.0;
                                $minutein = $minutein - 60.0;
                            }
                        }

                    }
                }
                if ($value->month == $calculations[$key+1]->month && $value->card_number == $calculations[$key+1]->card_number && $value->card_holder !== "未登録カード") {
//                     var_dump("value".$value->status.":".$value->company);
                    if ($value->status == '退室' && $value->company == '出側') {
//                            var_dump("count".$count.":".$key);
                        if ($key < ($count - 1)) {
                            $a = strtotime(($value->time));
                            $b = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                $f = ($b - $a) / 3600;
                            }
                            $sumout += $f;
                            $hoursout = floor($sumout);
                            $minuteout = round(60 * ($sumout - $hoursout));
                            if ($minuteout > 59) {
                                $hoursout = $hoursout + 1.0;
                                $minuteout = $minuteout - 60.0;
                            }
                        }
                    }
                }
            }
            //used to fetch the last time for the last data
            $last_month=$value->month;
            $last_day=$value->day;
            $last_time=$value->time;
        }
        // only last data
        $list2[] = array('month' => $last_month, "day" => $last_day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout,"enter"=>$enter_time,"exit"=>$last_time,"card_holder"=>$value->card_holder,"card_number"=>$value->card_number);
        return response((array)$list2);
    }
    public function total()
    {
        // Used to select year in the display list
        $users = Customer::paginate(50);
        $years = DB::table('customers')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->groupBy("year")
            ->orderBy("year",'desc')
            ->get();
        // used to select months in the display list
        $months = DB::table('customers')
            ->select(DB::raw('MONTH(created_at) as month'))
            ->groupBy("month")
            ->get();

        return view('file.total_list', compact('users','years','months'));
    }
    public function total_list(){
        // used to send ajax response to the total_list blade
        $yearInput = Input::get('year');
        $monthInput = Input::get('month');
        $calculations = DB::table('customers')
            ->select(DB::raw('created_at,time(created_at) as time,day(created_at) as day,month(created_at) as month,card_holder,card_number,card_holder,status,company'))
            ->whereRaw('year(created_at) =?', [$yearInput])
            ->whereRaw(('month(created_at) =?'), [$monthInput])
            ->orderBy('card_number', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();
// ===========================================================================================All intializations  start
        $sumin = 0.0;      // Intializing the time total that the employee stayed in office
        $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
        $count = count($calculations);
        $everyday_first_data_flg=1;
        $sumin = 0.0;      // Intializing the time total that the employee stayed in office
        $sumout = 0.0;
        $enter_time=0;
            //Intializing average checkout time
        $avg_exit_hour_sum=0.0;
        $avg_exit_minute_sum=0.0;
        $avg_exit_second_sum=0.0;
            //Intializing average entrance time
        $avg_enterance_hour_sum=0.0;
        $avg_enterance_minute_sum=0.0;
        $avg_enterance_second_sum=0.0;
        $average_h_m_s=0;
        $average_enterance=0;
        $average_enterance_hour=0;
        $average_enterance_minute=0;
        $average_enterance_second=0;

        $average_exit=0.0;
        $exit_time_sum=0.0;

//        $average_enterance=0;
        $count_enterance_time=1;
        $count_exit_time=1;
// ===========================================================================================All intializations ends
        foreach ($calculations as $key => $value) {
            if ($key < ($count - 1)) {
                //Average enreance time
                if ($everyday_first_data_flg === 1) {
                    $enter_time = $value->time;
                    $a = preg_split('/[: ]/', $enter_time);
                    $hour = $a[0];
                    $minute = $a[1];
                    $second = $a[2];
//                    if ($value->day)
                    if ($hour < 10) {
                        $avg_enterance_hour_sum = $avg_enterance_hour_sum + $hour;
                        $avg_enterance_minute_sum = $avg_enterance_minute_sum + $minute;
                        $avg_enterance_second_sum = $avg_enterance_second_sum + $second;
//                        var_dump($avg_enterance_hour_sum);
//                        var_dump($count_enterance_time);
                        $average_enterance_hour = floor($avg_enterance_hour_sum / $count_enterance_time);
                        $average_enterance_minute = round($avg_enterance_minute_sum / $count_enterance_time) + round(60 * ($avg_enterance_hour_sum / $count_enterance_time - $average_enterance_hour));
                        $average_enterance_second = round($avg_enterance_second_sum / $count_enterance_time);

                        if ($average_enterance_minute > 59) {
                            $average_enterance_hour = $average_enterance_hour + 1;
                            $average_enterance_minute = $average_enterance_minute - 60.0;
                        }
                        if ($average_enterance_second > 59) {
                            $average_enterance_minute = $average_enterance_minute + 1.0;
                            $average_enterance_second = $average_enterance_second - 60.0;
                        }
                        $count_enterance_time++;
                    }
                    $average_enterance = $average_enterance_hour . ":" . $average_enterance_minute . ":" . $average_enterance_second;
                }
                if ($value->card_number != $calculations[$key + 1]->card_number || $value->day != $calculations[$key + 1]->day) {
                    $everyday_first_data_flg = 1;
                } else {
                    $everyday_first_data_flg = 0;
                }
//                Average exit time
                if ($value->day !== $calculations[$key + 1]->day) {
                    $exit_time = $value->time;
                    $b = preg_split('/[: ]/', $exit_time);
                    $hour = $b[0];
                    $minute = $b[1];
                    $second = $b[2];
                    if ($hour > 11) {
                        $avg_exit_hour_sum = $avg_exit_hour_sum + $hour;
                        $avg_exit_minute_sum = $avg_exit_minute_sum + $minute;
                        $avg_exit_second_sum = $avg_exit_second_sum + $second;
                        $average_exit_hour = floor($avg_exit_hour_sum / $count_exit_time);
                        $average_exit_minute = round($avg_exit_minute_sum / $count_exit_time) + round(60 * ($avg_exit_hour_sum / $count_exit_time - $average_exit_hour));
                        $average_exit_second = round($avg_exit_second_sum / $count_exit_time);
                        if ($average_exit_second > 59) {
                            $average_exit_minute = $average_exit_minute + 1.0;
                            $average_exit_second = $average_exit_second - 60.0;
                        }
                        if ($average_exit_minute > 59) {
                            $average_exit_hour = $average_exit_hour + 1.0;
                            $average_exit_minute = $average_exit_minute - 60.0;
                        }
                        $count_exit_time++;
                    }
                    $average_h_m_s = $average_exit_hour . ":" . $average_exit_minute . ":" . $average_exit_second;
                }
                // reset ( every day )
                if ($value->day !== $calculations[$key + 1]->day && $value->card_number !== $calculations[$key + 1]->card_number) {
                    $list2[] = array('month' => $value->month, 'card_number' => $value->card_number, 'card_holder' => $value->card_holder, "day" => $value->day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout, "enter" => $average_enterance, "exit" => $average_h_m_s);
                    $everyday_first_data_flg = 1;
                    //        var_dump($valuelist);
                    $sumin = 0.0;     // Intializing the time total that the employee stayed in office
                    $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
                    $minutein = 0.0;
                    $minuteout = 0.0;
                    $count_exit_time = 1;
                    $count_enterance_time = 1;
                    //reseting exit time
                    $avg_exit_hour_sum = 0;
                    $avg_exit_minute_sum = 0;
                    $avg_exit_second_sum = 0;
                    //resting entrance time
                    $avg_enterance_hour_sum = 0;
                    $avg_enterance_minute_sum = 0;
                    $avg_enterance_second_sum = 0;
                }
                if ($value->month == $calculations[$key + 1]->month && $value->card_number == $calculations[$key + 1]->card_number && $value->card_holder !== "未登録カード") {
                    if ($value->status == '入室' && $value->company == '入側') {
//                        var_dump("ok3");
                        if ($key < ($count - 1)) {
//                            var_dump($value->card_holder);
                            $x = strtotime(($value->time));
                            $y = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                $z = ($y - $x) / 3600;
                            }
                            $sumin += $z;
                            $hoursin = floor($sumin);
                            $minutein = round(60.0 * ($sumin - $hoursin));
                            if ($minutein > 59) {
                                $hoursin = $hoursin + 1.0;
                                $minutein = $minutein - 60.0;
                            }
                        }

                    }
                }
                if ($value->month == $calculations[$key + 1]->month && $value->card_number == $calculations[$key + 1]->card_number && $value->card_holder !== "未登録カード") {
//                     var_dump("value".$value->status.":".$value->company);
                    if ($value->status == '退室' && $value->company == '出側') {
//                            var_dump("count".$count.":".$key);
                        if ($key < ($count - 1)) {
                            $a = strtotime(($value->time));
                            $b = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                $f = ($b - $a) / 3600;
                            }
                            $sumout += $f;
                            $hoursout = floor($sumout);
                            $minuteout = round(60.0 * ($sumout - $hoursout));
                            if ($minuteout > 59) {
                                $hoursout = $hoursout + 1.0;
                                $minuteout = $minuteout - 60.0;
                            }
                        }
                    }
                }
            }

            //used to fetch the last time for the last data
            $last_month = $value->month;
            $last_day = $value->day;
            $last_time = $value->time;

//            echo("[everyday_first_data_flg:".$everyday_first_data_flg ."]===<br /><br />");
        }

        // only last data
        $list2[] = array('month' => $last_month, "day" => $last_day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout,"enter"=>$average_enterance,"exit"=>$average_h_m_s,"card_holder"=>$value->card_holder,'card_number' => $value->card_number);
        return response((array)$list2);
    }
    public function getImport()
    {
        return view('file.upload');
    }
    public function postImport()
    {
        //used to import the files to the database and directory in the import page
        if(Input::hasFile('upload')){
            $path = Input::file('upload');
            foreach($path as $file) {
                $data = Excel::load($file, function ($reader) {
                    $reader->noHeading();
                }, 'shift_jis')->all()->toArray();
                $count = count($file);
                $name = $file->getClientOriginalName();
                if (!file_exists("uploaded_files/".$name)) {
                    $file->move("uploaded_files", $name);
                    if (!empty($data) && $count) {
                        foreach ($data as $key => $value) {
                            $count_value = count($value);
                            if ($count_value == 10) { // Normal data list
                                $insert[] = ['created_at' => $value[0], 'in' => $value[1], 'out' => $value[2], 'door' => $value[3], 'status' => $value[4], 'company' => $value[5], 'status2' => $value[6], 'company2' => $value[7], 'card_number' => $value[8], 'card_holder' => $value[9]];
                            } elseif ($count_value < 10)//  skips the empty data company2 is empty and skipped
                            {
                                $insert[] = ['created_at' => $value[0], 'in' => $value[1], 'out' => $value[2], 'door' => $value[3], 'status' => $value[4], 'company' => $value[5], 'status2' => $value[6], 'company2' => null, 'card_number' => $value[7], 'card_holder' => $value[8]];
                            }
                        }// end of foreach
                    }
                }
                else{

    echo"<script type=\"text/javascript\">window.alert('そのファイルは、すでにアップロードされています。別のファイルを選んでください。');
         window.location.href = '/getImport';
         </script>";
//                    return back();
                }
            }
            //Used to insert the insert array values to the database
            if(!empty($insert)){
                DB::table('customers')->insert($insert);
                return redirect('/home')->with("インポートが完了しました。");
            }
        } // if end
    }
    public function getExport()
    {
        //used export all database data to excel in the home page
        $export = Customer::all();
        Excel::create(date('Y/m/d').'Key-p data', function ($excel) use ($export) {
            $excel->sheet('Sheet 1', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xls');
        return redirect()->back();
    }
    public function getDelete()
    {
        // this function is used to delete both the database data and the directory files together in the home page
        Session::has('delete_all','ファイルをすべて削除します。');
        DB::table('customers')->delete();
        $files = public_path().'/uploaded_files/';
        array_map('unlink', glob("$files/*.dat"));
        return redirect()->back();
    }
    public function getsearch()
    {
        //used to select months
        $customers = DB::table('customers')
            ->select(DB::raw('MONTH(created_at) as month'))
            ->groupBy("month")
            ->get();
        // used to select years
        $customer1 = DB::table('customers')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->groupBy("year")
            ->orderBy("year","desc")
            ->get();
        // used to group users
        $customer2 = Customer::groupBy('card_holder')->get();
        $yearInput = Input::get('year');
        $monthInput = Input::get('month');
        $nameInput = Input::get('name');
        $displays = DB::table('customers')
            ->select(DB::raw('day(created_at) as day,card_holder,month(created_at)'))
            ->whereRaw('year(created_at) =?', [$yearInput])
            ->whereRaw(('month(created_at) =?'), [$monthInput])
            ->whereRaw(('card_holder like ?'), [$nameInput])
            ->groupBy('day')->get();
        return view('file.searchs', compact('customers', 'customer1', 'customer2', 'displays'));
    }
    public function display()
    {
        $yearInput = Input::get('year');
        $monthInput = Input::get('month');
        $nameInput = Input::get('name');
        // database data for calculation  for each date
        $calculations = DB::table('customers')
            ->select(DB::raw('created_at,time(created_at) as time,day(created_at) as day,month(created_at) as month,card_holder,status,company'))
            ->whereRaw('year(created_at) =?', [$yearInput])
            ->whereRaw(('month(created_at) =?'), [$monthInput])
            ->whereRaw(('card_holder like ?'), [$nameInput])
            ->orderBy('created_at', 'asc')
            ->get();
        $sumin = 0.0;      // Intializing the time total that the employee stayed in office
        $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
        $count = count($calculations);
        $displaylist = [];
        $valuelist = [];
        $everyday_first_data_flg=1;
            $sumin = 0.0;      // Intializing the time total that the employee stayed in office
            $sumout = 0.0;
            $avg_enterance_hour=0.0;
            $avg_enterance_minute=0.0;
            $avg_enterance_second=0.0;
            $count2=0;
            foreach ($calculations as $key => $value) {
                if($everyday_first_data_flg===1) {
                    $enter_time=$value->time;
                    $a      = preg_split('/[: ]/', $enter_time);
                    $count2++;
                    $hour   = $a[0];
                    $minute = $a[1];
                    $second   = $a[2];
                    if($hour<10){
                        $avg_enterance_hour=$avg_enterance_hour+$hour;
                        $avg_enterance_minute=$avg_enterance_minute+$minute;
                        $avg_enterance_second=$avg_enterance_second+$second;
                    }
                    else{
                        $count2--;
//                        $minute=0;
//                        $second=0;
                    }
                    $everyday_first_data_flg = 0;
                }
                // reset ( every day )
                if ($key < ($count-1)) {
                    if ($value->day !== $calculations[$key + 1]->day) {
                        $list2[] = array('month' => $value->month, "day" => $value->day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout,"enter" =>$enter_time, "exit" =>$calculations[$key]->time);
                        $everyday_first_data_flg=1;
                        //        var_dump($valuelist);
                        $sumin  = 0.0;     // Intializing the time total that the employee stayed in office
                        $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
                        $minutein=0.0;
                        $minuteout=0.0;
                   }
                }
                if ($value->day == $calculations[$key]->day) {
                    if ($value->status == '入室' && $value->company == '入側') {
//                        var_dump("ok3");
                        if ($key < ($count - 1)) {
                            $x = strtotime(($value->time));
                            $y = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                $z = ($y - $x) / 3600;
                            }
                            $sumin += $z;
                            $hoursin = floor($sumin);
                            $minutein = round(60 * ($sumin - $hoursin));
                            if ($minutein>59){
                                $hoursin=$hoursin+1.0;
                                $minutein=$minutein-60.0;
                            }
                        }

                    }
                }
                 if ($value->day == $calculations[$key]->day) {
//                     var_dump("value".$value->status.":".$value->company);
                        if ($value->status == '退室' && $value->company == '出側') {
//                            var_dump("count".$count.":".$key);
                          if($key < ($count-1) ){
                            $a = strtotime(($value->time));
                            $b = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                   $f = ($b - $a) / 3600;
                               }
                            $sumout += $f;
                            $hoursout = floor($sumout);
                            $minuteout = round(60 * ($sumout - $hoursout));
                              if ($minuteout>59){
                                  $hoursout=$hoursout+1.0;
                                  $minuteout=$minuteout-60.0;
                              }
                          }
                        }
                    }
                //used to fetch the last time for the last data
                $last_month=$value->month;
                $last_day=$value->day;
                $last_time=$value->time;
        }
        $average_hour=floor($avg_enterance_hour/$count2);
        $average_minute=floor($avg_enterance_minute/$count2);
        $average_second=floor($avg_enterance_second/$count2);
        $average_enterance=$average_hour.":".$average_minute.":".$average_second;
        // only last data
        $list2[] = array('month' => $last_month, "day" => $last_day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout,"enter"=>$enter_time,"exit"=>$last_time,"card_holder"=>$value->card_holder,"average_enterance"=>$average_enterance);
        return response((array)$list2);
    }
    public function daily_display()
    {
        $yearInput = Input::get('year');
        $monthInput = Input::get('month');
        $dayInput = Input::get('day');
        $calculations = DB::table('customers')
            ->select(DB::raw('created_at,time(created_at) as time,day(created_at) as day,month(created_at) as month,card_holder,card_number,status,company'))
            ->whereRaw('year(created_at) =?', [$yearInput])
            ->whereRaw(('month(created_at) =?'), [$monthInput])
            ->whereRaw(('day(created_at)=?'),[$dayInput])
            ->orderBy('card_number', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();
//        var_dump($calculations);
        $sumin = 0.0;      // Intializing the time total that the employee stayed in office
        $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
        $count = count($calculations);
        $displaylist = [];
        $valuelist = [];
        $everyday_first_data_flg=1;
        $sumin = 0.0;      // Intializing the time total that the employee stayed in office
        $sumout = 0.0;
        foreach ($calculations as $key => $value) {
//            var_dump($key);
//            var_dump("-");
            if($everyday_first_data_flg===1) {
                $enter_time=$value->time;
                $everyday_first_data_flg = 0;
            }
            // reset ( every day )
            if ($key < ($count-1)) {
//            var_dump($value->card_number );
//            var_dump("<br/>");
//            var_dump($calculations[$key ]->card_number);

                if ($value->card_number !== $calculations[$key + 1]->card_number) {
                    $list2[] = array("sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout, "enter" => $enter_time, "exit" => $calculations[$key]->time, "card_holder" => $value->card_holder);
//                    var_dump($list2);

                    $everyday_first_data_flg = 1;
                    //        var_dump($valuelist);
                    $sumin = 0.0;     // Intializing the time total that the employee stayed in office
                    $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
                    $minutein = 0.0;
                    $minuteout = 0.0;
                }

                if ($value->card_number == $calculations[$key+1]->card_number) {
                    if ($value->status == '入室' && $value->company == '入側') {
//                        var_dump("ok3");
                        if ($key < ($count - 1)) {
                            $x = strtotime(($value->time));
                            $y = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                $z = ($y - $x) / 3600;
                            }
                            $sumin += $z;
                            $hoursin = floor($sumin);
                            $minutein = round(60 * ($sumin - $hoursin));
                            if ($minutein > 59) {
                                $hoursin = $hoursin + 1.0;
                                $minutein = $minutein - 60.0;
                            }
                        }

                    }
                }
                if ($value->card_number == $calculations[$key+1]->card_number) {
//                     var_dump("value".$value->status.":".$value->company);
                    if ($value->status == '退室' && $value->company == '出側') {
//                            var_dump("count".$count.":".$key);
                        if ($key < ($count - 1)) {
                            $a = strtotime(($value->time));
                            $b = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                $f = ($b - $a) / 3600;
                            }
                            $sumout += $f;
                            $hoursout = floor($sumout);
                            $minuteout = round(60 * ($sumout - $hoursout));
                            if ($minuteout > 59) {
                                $hoursout = $hoursout + 1.0;
                                $minuteout = $minuteout - 60.0;
                            }
                        }
                    }
                }
            }
            //used to fetch the last time for the last data
//            $last_month=$value->month;
//            $last_day=$value->day;
            $last_time=$value->time;
        }
        // only last data
        $list2[] = array("sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout,"enter"=>$enter_time,"exit"=>$last_time,"card_holder"=>$value->card_holder);
//        var_dump($list2);
        return response((array)$list2);
    }
    public function lists(){
        $files = public_path().('/uploaded_files/');
        $path=scandir($files, 1);// used to list all files in the directory
        return view('file.list',compact('files'));
    }
    public function getDownload($filename){
        $path= public_path()."/uploaded_files/".$filename;
        return response()->download($path);// to download individual file from  the public directory
    }
    public function getDeletes($filename){
        Session::flash('delete_media','ファイルを削除しました。');
        $path= public_path()."/uploaded_files/".$filename;
        unlink($path);//used to delete a single file from the directory
        return redirect()->back();
    }
    public function getDeleteall(){
        $files = public_path().'/uploaded_files/';
        $path=scandir($files,1);
        array_map('unlink', glob("$files/*.dat"));// Used to delete or unlink all the data in the directory in the dat file upload page
        return redirect()->back();
    }
}