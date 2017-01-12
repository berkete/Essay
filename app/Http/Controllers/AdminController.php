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
    //
    public function index()
    {


        $users = Customer::all();
        return view('file.index', compact('users'));
    }

    public function getImport()
    {

        return view('file.upload');
    }

    public function postImport()
    {
        Excel::load(Input::file('upload'), function ($reader) {
            $reader->each(function ($sheet) {
//               $sheet->selectSheets('sheet1','sheet2');
                Customer::firstOrCreate($sheet->toArray());

            });


        });

        return redirect('/home');

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


    public function getCalculation()
    {

//        $customers=Customer::where('active',true)->orderBy('card_holder')->pluck('card_holder','id');

        $customers = Customer::groupBy('card_holder')->paginate(20);
//        $customers=Customer::all()->pluck('label','id');
//        $customers= Customer::groupBy('card_holder')->pluck('card_holder','id')->toArray();
//        $creates=Customer::lists('created_at','id');

//       $customers=Customer::whereYear('created_at','=',$year)->whereMonth('created_at','=',$month)->get();
//        $year=$customers->created_at->year;
//        $month=$customers->created_at->month;

        return view('file.main', compact('customers'));
    }


    public function store()
    {

        return 'it works';

    }

    public function duplicate()
    {
        $user = Input::get('option');
        $items = Customer::where('id', '=', $user)->pluck('card_holder', 'id');
        return view('file.show', compact('items'));


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

//        $yearInput=2016;
//        $monthInput=8;
//        $nameInput='大西　正晃';
        $yearInput = Input::get('year');
        $monthInput = Input::get('month');
        $nameInput = Input::get('name');

        $displays = DB::table('customers')
            ->select(DB::raw('day(created_at) as day,card_holder,month(created_at)'))
            ->whereRaw('year(created_at) =?', [$yearInput])
            ->whereRaw(('month(created_at) =?'), [$monthInput])
            ->whereRaw(('card_holder like ?'), [$nameInput])
            //            ->whereRaw('month(created_at) = :month and year(created_at) = :year and card_holder=:name', ['month' => $monthInput,'year' => $yearInput,'name'=>$nameInput])

            ->groupBy('day')->get();


        return view('file.searchs', compact('customers', 'customer1', 'customer2', 'displays'));
    }

    public function test()
    {
        // Used to search from the select box
        $month = Input::get('month');
        $name = Input::get('name');
        $year = Input::get('year');
        $custs = Customer::where('card_holder', 'LIKE', '%' . $name . '%')
            ->where('created_at', 'LIKE', '%' . $month . '%')
            ->where('created_at', 'LIKE', '%' . $year . '%')
            ->get();
        if (count($custs) > 0)
            return view('file.test')->withDetails($custs);
        else
            return view('file.test')->withMessage('No such user');

    }

    public function test2()
    {
        $q = Input::get('customers' || 'customers2' || 'customers4');
        $custs = Customer::where('created_at', 'LIKE', '%' . $q . '%')
            ->orWhere('card_holder', 'LIKE', '%' . $q . '%')
            ->orWhere('card_number', 'LIKE', '%' . $q . '%')
            ->groupBy('card_number')->get();


        if (count($custs))
            return view('file.test')->withDetails($custs)->withQuery($q);
        else
            return view('file.test')->withMessage('No such user');
    }

    public function getCampaigns()
    {
//        $list1 = Input::get('id');
        $customers = Customer::groupBy('card_holder')->get();
//            ->where('id','=', $list1)
//            ->get();
        return view('file.index2', compact('customers'));
    }

    public function update()
    {

//        DB::statement(('update users u'),
//                join (['customers c','u']),
//                SET ('u.id2=c.card_number'));

//        DB::table('update users u join customers c
//             SET u.id2 =c.card_number || u.name=c.card_holder');
        return redirect()->back();
    }

    public function post($id)
    {

        $posts = User::where('id', '=', $id)->get();
        return view('file.post', compact('posts'));


    }

    public function calculation()
    {

        $customers = [];
        $sumin = 0;
        $sumout = 0;

        foreach (Customer::all() as $customer) {
            for ($i = 0; $i < count($customer->id); $i++) {
                if ($customer->status == '入室' && $customer->company == '	入側') {

                    $customers[$customer->id] = \Carbon\Carbon::parse($customer->created_at)->format('h:i:s');


                    $x = $customers[$i + 1] - $customers[$i];
                    $sumin = $sumin + $x;
                }


                $customers = $sumin;
//var_dump($customers);
            }
            if ($customer->status == '退室' && $customer->company == '	出側') {
                $customers[] = \Carbon\Carbon::parse($customer->created_at)->format('h:i:s');
                $y = $customers[$i] - $customers[$i + 1];
                $sumout = $sumout + $y;

                $customers[] = $sumout;
            } else {
//              $customers[]="none";

            }


        }
        return view('file.calculation', compact('customers'));


    }

    public function select()
    {
        $customers = [];
        foreach (Customer::all() as $customer) {
//       $customer->groupBy('card_holder');
            $customers[$customer->id] = $customer->card_holder;

        }
        $year = [];
        foreach (Customer::all() as $customer) {
            $year[$customer->id] = \Carbon\Carbon::parse($customer->created_at)->format('Y');


        }

        $card_number = [];
        foreach (Customer::all() as $customer) {
            $card_number[$customer->id] = $customer->card_number;

        }
        $month = [];
        foreach (Customer::all() as $customer) {
            $month[$customer->id] = \Carbon\Carbon::parse($customer->created_at)->format('m');
//                                    ->groupBy('m')
//                                    ->get();


        }


        return View::make('file.select', compact('customers', 'year', 'card_number', 'month'));


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
            ->select(DB::raw('created_at,time(created_at) as time,day(created_at) as day,month(created_at) as month,status,company'))
            ->whereRaw('year(created_at) =?', [$yearInput])
            ->whereRaw(('month(created_at) =?'), [$monthInput])
            ->whereRaw(('card_holder like ?'), [$nameInput])
            ->orderBy('created_at','asc')
            ->get();

////        error_log("shume2:-".$calculations."get\n",3,"/Applications/XAMPP/logs/error_log");
        $sumin = 0.0;      // Intializing the time total that the employee stayed in office
        $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
        $count = count($calculations);
        $displaylist = [];
        $valuelist = [];
//=======================another trial
        foreach ($displays as $display) {
//            var_dump($display->day);

            $displaylist[] = $display->day;
            //    var_dump($displaylist);

        }

        foreach ($calculations as $key => $value) {
//            var_dump($value->month);
//            $valuelist[]=$value->day;

var_dump($value->created_at);
            echo("<br />");
//            var_dump($value->day ."==". $calculations[$key + 1]->day);
            echo("<br />");
            if ($key < ($count-1)) {
                if ($value->day !== $calculations[$key + 1]->day) {

                    //        var_dump($valuelist);
                    $sumin = 0.0;      // Intializing the time total that the employee stayed in office
                    $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
//            $count = count($calculations);
//            $hoursin=0;
//            $hoursout=0;
//            $minuteout=0;
//            $minutein=0;

                }
            }
//            var_dump($key);

                if ($value->status == '入室' && $value->company == '入側' ) {
                    if ($key < ($count-1)) {
                       if ($value->day==$calculations[$key+1]->day){
                            $x = strtotime(($value->time));
                            $y = strtotime($calculations[$key + 1]->time);
//                            var_dump("x=:".$x);
//                           echo("<br />");
//                            var_dump("y=:".$y);
//                           echo("<br />");
                            $z = abs(($y - $x) / 3600);
//                            var_dump("z=:".$z);
//                           echo("<br />");
                            $sumin += $z;
//                            var_dump("sumin=:".$sumin);
//                           echo("<br />");
                            //Changing to hours and minutes
                            $hoursin = floor($sumin);
                            $minutein = round(60 * ($sumin - $hoursin));
//                        var_dump("hours in:".$hoursin);
//                        var_dump("minute in:".$minutein);
//                        $sumin = $hoursin;





                        }
//                            var_dump();


                    }

                }

//                if ($key < ($count-1)&& $calculations[$key]->day!= $display->day ) {

                elseif ($key < ($count - 1) && $value->status == '退室' && $value->company == '出側') {
//                            var_dump("[IN]");
                    if ($key < ($count-1)) {
                      if ($value->day==$calculations[$key+1]->day) {
                          $a = strtotime(($value->time));
                          $b = strtotime($calculations[$key + 1]->time);
                          var_dump("a=:" . $a);
                          echo("<br />");

                          var_dump("b=:" . $b);

                          $f = abs(($b - $a) / 3600);
                          var_dump("f=:" . $f);
                          echo("<br />");

                          $sumout += $f;
                          var_dump("sumout=:" . $sumout);
                          echo("<br />");

                          $hoursout = floor($sumout);
                          $minuteout = round(60 * ($sumout - $hoursout));
                        var_dump("hours out".$hoursout);
//                    var_dump("minutes out".$minuteout);
//                        $sumout=$hoursout*(-1);
                      }
                    }

//                    var_dump($valuelist);
                }


//            $list2[]=array('month'=>$value->month,"day"=>$value->day,"sumin"=>$hoursin,"minutein"=>$minutein,"sumout"=>$hoursout,"minuteout"=>$minuteout,"enter"=>$display->time,"exit"=>$display->timee);



        }
//        return response((array)$list2);
    }
}

//=======================another trial
//=================================better work
//
//        foreach ($displays as $display) {
//            $sumin = 0.0;      // Intializing the time total that the employee stayed in office
//            $sumout = 0.0;
//            foreach ($calculations as $key => $value) {
////                var_dump($display->day);
//
//                if ($display->day == $calculations[$key]->day) {
//                    if ($value->status == '入室' && $value->company == '入側') {
//                        if ($key < ($count-1) ){
////                            var_dump($count);
//                            $x = strtotime(($value->time));
//                            $y = strtotime($calculations[$key+1]->time);
////                        var_dump("x=:".$x);
////                        var_dump("y=:".$y);
//                            $z = ($y - $x)/3600;
////                        var_dump("z=:".$z);
//                            $sumin +=$z;
////                        var_dump("sumin=:".$sumin);
//                            //Changing to hours and minutes
//                            $hoursin = floor($sumin);
//                            $minutein = round(60 * ($sumin - $hoursin));
////                        var_dump("hours in:".$hoursin);
////                        var_dump("minute in:".$minutein);
////                        $sumin = $hoursin;
//
//                        }
//
//                    }
//
////                if ($key < ($count-1)&& $calculations[$key]->day!= $display->day ) {
//
//                    if ($key < ($count-1) && $value->status == '退室' && $value->company == '出側') {
////                            var_dump("[IN]");
//                        $a = strtotime(($value->time));
//                        $b = strtotime($calculations[$key+1]->time);
////                        var_dump("a=:".$a);
////                        var_dump("b=:".$b);
//
//                        $f = ($b - $a)/3600;
////                        var_dump("f=:".$f);
//                        $sumout +=  $f;
////                        var_dump("sumout=:".$sumout);
//                        $hoursout=floor($sumout);
//                        $minuteout=round(60*($sumout-$hoursout));
////                        var_dump("hours out".$hoursout);
////                        $sumout=$hoursout*(-1);
//
//                    }
////
//                }
//
//
//            }
//            $list2[]=array('month'=>$display->month,"day"=>$display->day,"sumin"=>$hoursin,"minutein"=>$minutein,"sumout"=>$hoursout,"minuteout"=>$minuteout,"enter"=>$display->time,"exit"=>$display->timee);
//
//
//        }
//        return response((array)$list2);


//===============================================better works


//            }


//==========================================first trial

////        $checkout_time=Carbon\Carbon::now();
//        if ($calculations) {
//            foreach ($calculations as $key => $value) {
//                var_dump($value->company);
////                error_log("shume-status:-".$value["status"]."get\n",3,"/Applications/XAMPP/logs/error_log");
////                error_log("shume-company:-".$value["company"]."get\n",3,"/Applications/XAMPP/logs/error_log");
////
//                if ($value->status == '入室' && $value->company == '入側') {
//                    if ($key < $count) {
//                    $x = strtotime(($value->time));
//                    $y = strtotime(next($calculations)->time);
//                    $z = ($y - $x)/3600;
//                    $sumin = $sumin + $z;
//                    //Changing to hours and minutes
//                    $hoursin=floor($sumin);
//                    $minutein=round(60*($sumin-$hoursin));
//                    $sumin=$hoursin;
//                    }
//                }
//                if ($value->status == '退室' && $value->company == '出側') {
//                    if ($key < ($count - 1)) {
////                            var_dump("[IN]");
//                        $a = strtotime(($value->time));
//                        $b = strtotime(next($calculations)->time);
//                        $f = ($b - $a)/3600;
//                        $sumout = ($sumout + $f);
//                        $hoursout=floor($sumout);
//                        $minuteout=round(60*($sumout-$hoursout));
//                        $sumout=$hoursout*(-1);
//
//                    }
//
//                }
//
//
//            }
//


//        }

//        foreach ($displays as $display){
//           $count=count($calculations);
//            foreach ($calculations as $key => $value) {
//                if ($value->status == '入室' && $value->company == '入側' ) {
//                    if ($key < $count) {
////                        var_dump($display->day);
//
//                        //var_dump($value->day);
//                        if ($display->day!==$value->day){
//                            $x = strtotime($value->time);
//                            $y = strtotime($calculations[$key+1]->time);
//                            $z = ($y - $x)/3600;
//                            $sumin = $sumin + $z;
//                            //Changing to hours and minutes
//                            $hoursin=floor($sumin);
//                            $minutein=round(60*($sumin-$hoursin));
//                            $sumin=$hoursin;
//                        }
//
//                    }
//                }
//                if ($value->status == '退室' && $value->company == '出側') {
//                    if ($key < ($count - 1)) {
//                        if ($display->day!==$value->day) {
//                            $a = strtotime(($value->time));
//                            $b = strtotime($calculations[$key + 1]->time);
//                            $f = ($b - $a) / 3600;
//                            $sumout = ($sumout + $f);
//                            $hoursout = floor($sumout);
//                            $minuteout = round(60 * ($sumout - $hoursout));
//
//
//                            $sumout = ($hoursout) * (-1);
//                            //                        var_dump($sumout);
//                        }
//
//                    }
//
//                }
//
//
//            }

//            for ($i=0;$i<$count;$i++){
//                if ($display->status == '入室' && $display->company == '入側') {
//                    if ($i <$count) {
//                        var_dump($calculations[$i+1]->time);
//                        $x = strtotime(($display->time));
//                        $y = strtotime($displays[$i+1]->time);
//
//                        $z = ($y - $x)/3600;
//
//                        $sumin = $sumin + $z;
//
//                        //Changing to hours and minutes
//                        $hoursin=floor($sumin);
//                        $minutein=round(60*($sumin-$hoursin));
//                        $sumin=$hoursin;
//                    }
//                }
//                if ($display->status == '退室' && $display->company == '出側') {
//                    if ($i <=($count - 1)) {
////                            var_dump("[IN]");
//                        $a = strtotime(($display->time));
//                        $b = strtotime(next($display)->time);
//                        $f = ($b - $a)/3600;
//                        $sumout = ($sumout + $f);
//                        $hoursout=floor($sumout);
//                        $minuteout=round(60*($sumout-$hoursout));
//                        $sumout=$hoursout*(-1);
////
//                    }
//
//                }
//
//
//            }


//            $list2[]=array('month'=>$display->month,"day"=>$display->day,"sumin"=>$sumin,"minutein"=>$minutein,"sumout"=>$sumout,"minuteout"=>$minuteout,"enter"=>$display->time,"exit"=>$display->timee);
//        }

//        return response((array)$list2);
//=================================================================first trials
//        $list=array(array('month'=>'month1','days'=>'days1','sumin'=>'sumin1','sumout'=>'sumout1','enter'=>'enter1','exit'=>'exit1'),
//                    array('month'=>'month2','days'=>'days2','sumin'=>'sumin2','sumout'=>'sumout2','enter'=>'enter2','exit'=>'exit2'),
//                    array('month'=>'month3','days'=>'days3','sumin'=>'sumin3','sumout'=>'sumout3','enter'=>'enter3','exit'=>'exit3'),
//                    array('month'=>'month4','days'=>'days4','sumin'=>'sumin4','sumout'=>'sumout4','enter'=>'enter4','exit'=>'exit4'));

//        $list2[]=array('month'=>'septmeber','day'=>'monday','sumin'=>$sin,'sumout'=>$sout,'enter'=>'enter1','exit'=>'exit1');
//        $list2[]=array('month'=>'October','day'=>'tusday','sumin'=>2,'sumout'=>10,'enter'=>'enter2','exit'=>'exit2');
//        $list2[]=array('month'=>'Novemeber','day'=>'wensday','sumin'=>4,'sumout'=>11,'enter'=>'enter3','exit'=>'exit3');
//        $list2[]=array('month'=>'December','day'=>'thursday','sumin'=>5,'sumout'=>12,'enter'=>'enter4','exit'=>'exit4');


//        $arr=[$displays,'sumin'=>$sumin,'sumout'=>$sumout];
//        var_dump($displays);
//        var_dump($a);
//        var_dump($list);

//        echo('<br /><br /><br /><br />------------------<br /><br /><br /><br /><br />');
//        var_dump($list2);


// for try
//        $list=["animal"=>"dog", "plant"=>"flower"];
//        return $list;


