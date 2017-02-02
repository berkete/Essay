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
Route::get('/ajax-month',function (){
    $yearInput=Input::get('year');
//    $monthInput=Input::get('month');

    $year=DB::table('customers')
        ->select(DB::raw('month(created_at) as month '))
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
//    $monthInput=Input::get('month');
    $name=DB::table('customers')
        ->select(DB::raw('card_holder'))
        ->whereRaw('year(created_at) = :year', ['year' => $yearInput])
        ->groupBy('card_holder')->orderBy("card_number","ASC")->get();
    return $name;
});
//used to display the calculation result
Route::get('/display','AdminController@display');
//used to list monthly information
Route::get('/view_list','AdminController@view_list');
Route::get('/total_list','AdminController@total_list');
Route::get('/total','AdminController@total');
Route::get('/total_name_list','AdminController@total_name_list');
Route::get('/total_name','AdminController@total_name');
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


