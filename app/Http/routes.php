<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Customer;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Request;


Route::any('/campaigns/get', ['as' => '/campaigns/get', 'uses' => 'AdminController@getCampaigns']);
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


//to choose the specific

Route::get("/select",'AdminController@select');
Route::get('/ajax-month',function (){
    $yearInput=Input::get('year');
//    $year=2017;
//    $year=  Request::getContent('year');
//$someVariable = Input::get("some_variable");

//    $results = DB::select( DB::raw("SELECT * FROM some_table WHERE some_col = :somevariable"), array(
//        'somevariable' => $someVariable,
//    ));
    //select month(created_at) as month from `customers` where year(created_at) = 2016 group by month
    $year=DB::table('customers')
        ->select(DB::raw('month(created_at) as month '))
//        ->whereRaw('year(created_at) = 2016')
//        ->whereRaw('year(created_at) LIKE %', [$year],'%')
//        ->whereRaw('year(created_at) = ?',[$year])
        ->whereRaw('year(created_at) =?',[$yearInput])
        ->groupBy("month")
        ->get();
//    $str=["a","aaaaa","c"];

//    return Response()::json($test);
//    return Response::json($test);
    //var_dump($test);
    return $year;
});
Route::get('/ajax-name',function (){

    $yearInput=Input::get('year');
    $monthInput=Input::get('month');



    $month=DB::table('customers')
        ->select(DB::raw('card_holder'))
        ->whereRaw('month(created_at) = :month and year(created_at) = :year', ['month' => $monthInput,'year' => $yearInput])
//        ->whereRaw('year(created_at) = :year',['year' => $yearInput])->whereRaw('month(created_at) = :month',['month' => $monthInput])
//        ->whereRaw(('month(created_at) =?'),[$monthInput] && 'year(created_at) =?',[$yearInput])
//        ->whereRaw('year(created_at) =?',[$yearInput])
        ->groupBy('card_holder')->orderBy("card_number","ASC")->get();
//    return response()->json($month);

    return $month;
});
//used to display the result
Route::get('/display','AdminController@display');
Route::get('/post/{id}',['as'=>'post','uses'=>'AdminController@post']);
Route::get('/home','AdminController@index');
Route::any('/update','AdminController@update');
Route::get('/getImport',['as'=>'getImport','uses'=>'AdminController@getImport']);
Route::get('/getExport',['as'=>'getExport','uses'=>'AdminController@getExport']);
Route::get('/getDelete',['as'=>'getDelete','uses'=>'AdminController@getDelete']);
Route::post('/postImport',['as'=>'postImport','uses'=>'AdminController@postImport']);
Route::any('/search',function (){

$search=Input::get('search');
$customers= Customer::where('created_at','LIKE','%'.$search.'%')
                    ->where('in','LIKE','%'.$search.'%')
                    ->where('out','LIKE','%'.$search.'%')
                    ->where('door','LIKE','%'.$search.'%')
                    ->where('status','LIKE','%'.$search.'%')
                    ->where('company','LIKE','%'.$search.'%')
                    ->where('status2','LIKE','%'.$search.'%')
                    ->where('company2','LIKE','%'.$search.'%')
                    ->where('card_number','LIKE','%'.$search.'%')
                    ->where('card_holder','LIKE','%'.$search.'%')
                    ->paginate(10);
    if (count($customers))

        return view('file.search')->withDetails($customers)->withQuery($search);

    else
        return view('file.search')->withMessage('no detail found.Try again');



});

Route::get('/main','AdminController@getCalculation');
Route::get('/myurl',['as'=>'myurl','uses'=>'AdminController@duplicate']);
Route::any('/searchs','AdminController@test');
Route::any('/searchs2','AdminController@test2');
Route::any('/getsearch','AdminController@getsearch');
Route::any('/calculation','AdminController@calculation');
Route::get('/cal',function (){
    $customers2=[];
    foreach (Customer::all() as $customer) {

        $customers2[$customer->id] = \Carbon\Carbon::parse($customer->created_at)->format('h:i:s');


    }

    return view('file.cal',compact('customers2'));


});