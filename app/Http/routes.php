<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

use App\Customer;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Request;

Route::get('/', function () {
    $customers=[];
   foreach (Customer::all() as $customer) {
//       $customer->groupBy('card_holder');
       $customers[$customer->id] = $customer->card_holder;
   }
 $customers2=[];
      foreach (Customer::all() as $customer) {
          $customers2[$customer->id] = \Carbon\Carbon::parse($customer->created_at)->format('Y');
      }

    $customers3=[];
    foreach (Customer::all() as $customer) {
        $customers3[$customer->id] = $customer->card_number;
    }
    $customers4=[];
    foreach (Customer::all() as $customer) {
        $customers4[$customer->id] = \Carbon\Carbon::parse($customer->created_at)->format('m/d');
    }
    return View::make('welcome',compact('customers','customers2','customers3','customers4'));
//    return View::make('welcome',compact('customers','customers2','customers3','customers4'));

});

//used to return data to the ajax for dropdown lists
Route::get('/ajax-daily-val',function (){
    $yearInput=Input::get('year');
    $monthInput=Input::get('month');
    $dayInput=Input::get('day');
    $daily_validation=DB::table('customers')
        ->select(DB::raw('day(created_at) as day,month(created_at) as month,year(created_at) as year'))
        ->whereRaw('day(created_at)=:day and month(created_at) = :month and year(created_at) = :year', ['day'=>$dayInput,'month' => $monthInput,'year' => $yearInput])
        ->groupBy('day')
        ->get();
    if(!empty($daily_validation)){
        return $daily_validation;
    }
    else{
        return response(0);
    }

});
Route::get('/ajax-month',function (){
    $yearInput=Input::get('year');
//    $monthInput=Input::get('month');

    $year=DB::table('customers')
        ->select(DB::raw('month(created_at) as month','card_holder'))
        ->whereRaw('year(created_at) =?',[$yearInput])
        ->orderBy("month","desc")
        ->groupBy("month")
        ->get();
    return $year;
});
Route::get('/ajax-name',function (){
    $yearInput=Input::get('year');
    $monthInput=Input::get('month');
    $month=DB::table('customers')
        ->select(DB::raw('card_holder'))
        ->whereRaw('month(created_at) = :month and year(created_at) = :year', ['month' => $monthInput,'year' => $yearInput])
        ->groupBy('card_holder')->orderBy("card_number","ASC")->get();
    return $month;
});
Route::get('/ajax-name2',function (){
    $yearInput=Input::get('year');
    $name=DB::table('customers')
        ->select(DB::raw('card_holder'))
        ->whereRaw('year(created_at) = :year', ['year' => $yearInput])
        ->orderBy("card_number","ASC")
        ->groupBy('card_holder')
        ->get();
    return $name;
});

//used to choose days from the month
Route::get('/ajax-daily',function (){
    $yearInput=Input::get('year');
    $monthInput=Input::get('month');
    $daily=DB::table('customers')
        ->select(DB::raw('day(created_at) as day'))
        ->whereRaw('month(created_at) = :month and year(created_at) = :year', ['month' => $monthInput,'year' => $yearInput])
        ->orderBy("day","desc")
        ->groupBy('day')
        ->get();
    return $daily;
});
//used to choose days when selecting year
Route::get('/ajax-daily2',function (){
    $yearInput=Input::get('year');
    $daily2=DB::table('customers')
        ->select(DB::raw('day(created_at) as day'))
        ->whereRaw('year(created_at) = :year', ['year' => $yearInput])
        ->orderBy("day","desc")
        ->groupBy('day')->get();
    return $daily2;
});
Route::get('/daily_report','AdminController@daily_report');

//used to display the calculation result
Route::get('/display','AdminController@display');
Route::get('/daily_display','AdminController@daily_display');


//used to list monthly information
Route::get('/view_list','AdminController@view_list');
Route::get('/total_list','AdminController@total_list');
Route::get('/total','AdminController@total');
Route::get('/total_name_list','AdminController@total_name_list');
Route::get('/total_name','AdminController@total_name');

Route::get('/daily_report','AdminController@daily_report');

Route::get('/home','AdminController@index');


// The path for Import,export and delete the  data from the database
Route::get('/getImport',['as'=>'getImport','uses'=>'AdminController@getImport']);
Route::get('/getExport',['as'=>'getExport','uses'=>'AdminController@getExport']);
Route::get('/getDelete',['as'=>'getDelete','uses'=>'AdminController@getDelete']);
Route::post('/postImport',['as'=>'postImport','uses'=>'AdminController@postImport']);
//directing to the calculation
Route::any('/getsearch','AdminController@getsearch');
Route::get('/lists','AdminController@lists');
Route::get('/getDownload/{filename}','AdminController@getDownload');
Route::get('/getDeletes/{filename}','AdminController@getDeletes');
Route::get('/getDeleteall','AdminController@getDeleteall');


