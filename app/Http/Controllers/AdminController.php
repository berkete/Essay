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
        $customers=DB::table('customers')
                        ->select(DB::raw('MONTH(created_at) as month' ))
                        ->groupBy("month")
                        ->get();
                 // used to select years
        $customer1=DB::table('customers')
                        ->select(DB::raw('YEAR(created_at) as year' ))
                        ->groupBy("year")
                        ->get();
                // used to group users
        $customer2 = Customer::groupBy('card_holder')->get();

        return view('file.searchs', compact('customers','customer1','customer2'));
    }

    public function test()
    {
          // Used to search from the select box
        $month = Input::get('month' );
        $name = Input::get('name' );
        $year=  Input::get('year');
        $custs = Customer::where('card_holder', 'LIKE', '%'.$name.'%')
                         ->where('created_at', 'LIKE', '%'.$month.'%')
                         ->where('created_at', 'LIKE', '%'.$year.'%')
                         ->get();
        if (count($custs)>0)
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
        $customers= Customer::groupBy('card_holder')->get();
//            ->where('id','=', $list1)
//            ->get();
        return view('file.index2',compact('customers'));
    }

    public function update(){

//        DB::statement(('update users u'),
//                join (['customers c','u']),
//                SET ('u.id2=c.card_number'));

//        DB::table('update users u join customers c
//             SET u.id2 =c.card_number || u.name=c.card_holder');
        return redirect()->back();
    }

    public function post($id){

        $posts=User::where('id','=',$id)->get();
        return view('file.post',compact('posts'));


    }

    public function calculation(){

        $customers=[];
        $sumin=0;
        $sumout=0;

        foreach (Customer::all() as $customer){
            for ($i=0;$i<count($customer->id);$i++){
          if ($customer->status=='入室' && $customer->company=='	入側'){

                  $customers[$customer->id]=\Carbon\Carbon::parse($customer->created_at)->format('h:i:s');


                  $x=$customers[$i+1]-$customers[$i];
                  $sumin=$sumin+$x;
              }


           $customers=$sumin;
//var_dump($customers);
          }
          if($customer->status=='退室' && $customer->company=='	出側'){
              $customers[]=\Carbon\Carbon::parse($customer->created_at)->format('h:i:s');
              $y=$customers[$i]-$customers[$i+1];
              $sumout=$sumout+$y;

              $customers[]=$sumout;
          }

          else{
//              $customers[]="none";

          }


        }
        return view('file.calculation',compact('customers'));




    }

    public function select(){
        $customers=[];
        foreach (Customer::all() as $customer) {
//       $customer->groupBy('card_holder');
            $customers[$customer->id] = $customer->card_holder;

        }
        $year=[];
        foreach (Customer::all() as $customer) {
            $year[$customer->id] = \Carbon\Carbon::parse($customer->created_at)->format('Y');


        }

        $card_number=[];
        foreach (Customer::all() as $customer) {
            $card_number[$customer->id] = $customer->card_number;

        }
        $month=[];
        foreach (Customer::all() as $customer) {
            $month[$customer->id] = \Carbon\Carbon::parse($customer->created_at)->format('m');
//                                    ->groupBy('m')
//                                    ->get();


        }



        return View::make('file.select',compact('customers','year','card_number','month'));


    }

    public function display(){


        return view('file.search');

    }
}