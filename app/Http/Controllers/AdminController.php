<?php

namespace App\Http\Controllers;
use App\Customer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function index()
    {
          // Used to select year in the display list
        $users = Customer::paginate(50);
        $years = DB::table('customers')
            ->select(DB::raw('YEAR(created_at) as year'))
            ->groupBy("year")
            ->get();
         // used to select months in the display list
        $months = DB::table('customers')
            ->select(DB::raw('MONTH(created_at) as month'))
            ->groupBy("month")
            ->get();

        return view('file.index', compact('users','years','months'));
    }
    public function view_list(){
        $yearInput = Input::get('year');
        $monthInput = Input::get('month');
        $views = DB::table('customers')
            ->select(DB::raw('created_at,year(created_at) as year,month(created_at) as month,card_holder,door,status,company,company2,status2,card_number'))
            ->whereRaw('year(created_at) =?', [$yearInput])
            ->whereRaw(('month(created_at) =?'), [$monthInput])
//            ->whereRaw(('card_holder like ?'), [$nameInput])
            ->orderBy('created_at', 'asc')
            ->get();
//

//     $views=Customer::orderBy('created_at','asc')->get();
        $list2=array();
        foreach ($views as $view){
            $list2[] = array("dates" => $view->created_at, "door" => $view->door,"status" => $view->status, "company" => $view->company,"status2"=>$view->status2,"company2"=>$view->company2,"card_number"=>$view->card_number,
                "card_holder"=>$view->card_holder);
        }

        return response($list2);

    }
    public function getImport()
    {
        return view('file.upload');
    }
    public function postImport()
    {
        if(Input::hasFile('upload')){
//            $path = Input::file('upload')->getRealPath();
            $path = Input::file('upload');

//            $file_count = count($path);
            // start count how many uploaded
//            $uploadcount = 0;
            foreach($path as $file) {
                $data = Excel::load($file, function ($reader) {
                    $reader->noHeading();
                }, 'shift_jis')->all()->toArray();
                $count = count($file);
                $name = date("m-d:H") . $file->getClientOriginalName();
                $file->move("uploaded_files", $name);
                if(!empty($data) && $count) {
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
//
            }
                //Used to insert the insert array values to the database
                if(!empty($insert)){
                    DB::table('customers')->insert($insert);
                    return redirect('/home')->with("Insert Record successfully.");
                }

            } // if end


    }
    public function getExport()
    {
        $export = Customer::all();
        Excel::create('export data', function ($excel) use ($export) {
            $excel->sheet('Sheet 1', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });

        })->export('xls');

        return redirect()->back();

    }
    public function getDelete()
    {

        DB::table('customers')->delete();

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
        // Database data with specific days(group by day)
        $displays = DB::table('customers')
            ->select(DB::raw('day(created_at) as day,Month(created_at) as month,time(created_at)as time,MAX(time(created_at))as timee,card_holder,status,company'))
            ->whereRaw('year(created_at) =?', [$yearInput])
            ->whereRaw(('month(created_at) =?'), [$monthInput])
            ->whereRaw(('card_holder like ?'), [$nameInput])
            ->groupBy('day')->get();
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
//        $hoursin=0;
//        $minutein=0;
//        $hoursout=0;
//        $minuteout=0;
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

//                    var_dump("ok");
//                    var_dump($value->day);
//                    var_dump($calculations[$key + 1]->day);
                    if ($value->day !== $calculations[$key + 1]->day) {

//                        var_dump("ok2");

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

//                    var_dump("AAA:".$value->status .":".$value->company );

                                       // AAA:入側:入室
                    if ($value->status == '入室' && $value->company == '入側') {
//                        var_dump("ok3");
                        if ($key < ($count - 1)) {

//                            var_dump("ok4");


                            $x = strtotime(($value->time));
                            $y = strtotime($calculations[$key + 1]->time);
                            $z = ($y - $x) / 3600;
                            $sumin += $z;
                            $hoursin = floor($sumin);
                            $minutein = round(60 * ($sumin - $hoursin));
                            if ($minutein==60){
                                $hoursin=$hoursin+1;
                                $minutein=0.0;
                            }
//                            $sumin=$hoursin;
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
                              if ($minuteout==60){
                                  $hoursout=$hoursout+1;
                                  $minuteout=0.0;
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
        $list2[] = array('month' => $last_month, "day" => $last_day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout,"enter"=>$enter_time,"exit"=>$last_time,"card_holder"=>$value->card_holder);
        return response((array)$list2);

    }
}