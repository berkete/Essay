<style type="text/css">
    .ui-datepicker{
        background: dodgerblue;
        border: 1px solid #555;
        color: #EEE;
    }
    .ui-datepicker-trigger{
        background-color: dodgerblue;
        border: 1px solid #555;
        color: #AAAAAA;
        margin-top: 15px;
    }

</style>

$(document).ready(function() {
$("#fullDate").datepicker({
showOn:"button",
//            buttonImageOnly: true,
//            showButtonPanel: true,

buttonText: "Choose",
buttonImage:'images/calendar_icon.png',
changeMonth: true,
changeYear: true,
dayNamesMin: ['日', '月', '火', '水', '木', '金', '土'],
beforeShow: function(input,inst){
var year = $(this).parent().find("#year").val();
var month = $(this).parent().find("#month").val();
var date = $(this).parent().find("#day").val();
$(this).datepicker( "setDate" , year + "/" + month + "/" + date)
},
onSelect: function(dateText, inst) {
var datesplit=dateText.split('/');
var year=datesplit[2];
var months=datesplit[0];
var days=datesplit[1];


//                alert(days);
//                console.log("day"+days);
//                console.log("month"+months);
//                console.log("year"+year);
//                $("#year").append('<option value="'+ year+'">'+year+'</option>');
//                $("#month").append('<option value="'+ months+'">'+months+'</option>');
//                $("#day").append('<option value="'+ days+'">'+days+'</option>');
//                $(this).parents().find("#year").val(year).prop("selected",true);
//                $(this).parents().find("#month").val(months);
//                $(this).parents().find("#day").val(days);
////                $('#year').val(year);
//                $('#month').val(months);
//                $('#day').val(days);

}

});
});



//                        console.log("day"+days);
//                        console.log("month"+months);
//                        console.log("year"+year);
//                        $("#month").html('<option value="'+ months+'">'+months+'</option>');
$("#day").html('<option value="'+ days+'">'+days+'</option>');
$("#year").html('<option value="'+ year+'">'+year+'</option>');
$("#year").val(year).val();
if($('#year').val()===year){
//                            alert(year);

$("#day option[value='days']").attr("selected", true);
$('#year').removeAttr('disabled');
$("#day").val(days).prop('selected',true);
//
//                            $("#day").html('<option value="'+ days+'">'+days+'</option>');
//                            $.fn.myfunction();
//
//
//
}
//                    $("#year option[value=year]").prop('selected', true);
//                    $("#month option[value='months']").attr("selected", true);
//                    $("#day option[value='days']").attr("selected", true);


$('#year').val(year);
$('#month').val(months);
$('#day').val(days);


$(document).ready(function() {
$("#fullDate").datepicker({
showOn:"button",
//            buttonImageOnly: true,
showButtonPanel: true,
buttonText: "Choose",
buttonImage:'images/calendar_icon.png',
changeMonth: true,
changeYear: true,
dayNamesMin: ['日', '月', '火', '水', '木', '金', '土'],
gotoCurrent: true,
showAnim: "fold",
onSelect: function(dateText, inst) {
var datesplit=dateText.split('/');
var year=datesplit[2];
var months=datesplit[0];
var days=datesplit[1];
$('select#month').val(months);
$('select#day').val(days);
$('select#year').val(year);
//                        $.fn.myfunction();

}
});
});
$('#year').change(function() {
$('#month option').removeAttr('disabled'); // Enable all months
var today = new Date();
if ($(this).val() == today.getFullYear()) { // If current year
$('#month option:lt(' + today.getMonth() + ')').attr('disabled', true); // Disable earlier months
}
$('#month').change(); // Cascade changes
});
$('#month').change(function() {

$('#day option').removeAttr('disabled'); // Enable all days
var today = new Date();

if ($('#year').val() == today.getFullYear() && $(this).val() == (today.getMonth() + 1)) {
// If current year and month
$('#days option:lt(' + (today.getDate() - 1) + ')').attr('disabled', true); // Disable earlier days
}
checkDays(); // Ensure only valid dates
});
function checkDays() {
var daysInMonth = 32 - new Date($('#year').val(), $('#month').val(), 32).getDate();
$('#day option:gt(27)').removeAttr('disabled');
$('#day option:gt(' + (daysInMonth - 1) + ')').attr('disabled', true);
if ($('#day').val() > daysInMonth) {
$('#day').val(daysInMonth);
}
}


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
                        if ($key < ($count - 1)) {
                            if ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>='12:00:00' && $calculations[$key + 1]->time<='13:00:00') {
                                $calculations[$key+1]->time='12:00:00';
                            }
                            //reset 18:00:00
                            if ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>'18:00:00' && $calculations[$key + 1]->time<'18:30:00') {
                                $y = strtotime('18:00:00');
                            }else{
                                $y = strtotime($calculations[$key + 1]->time);
                            }
                            if ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>'18:30:00') {
                                $break_time= -0.5;
                            }else{
                                $break_time=0;
                            }
                            $x = strtotime(($value->time));
                            $y = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                $z = (($y - $x) / 3600)+$break_time;
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
                    if ($value->status == '退室' && $value->company == '出側') {
                        if ($key < ($count - 1)) {
                            if ( $calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側' && $calculations[$key + 1]->time>'12:00:00' && $calculations[$key + 1]->time<'13:00:00') {
                                $calculations[$key+1]->time='13:00:00';
                                continue;
                            }
                            if ( $calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側' && $calculations[$key + 1]->time>'18:00:00' && $calculations[$key + 1]->time<'18:30:00') {
                                $b = strtotime('18:30:00');
                            }else{
                                $b = strtotime($calculations[$key + 1]->time);
                            }
                            if ( $calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側'  && $calculations[$key + 1]->time>'18:30:00') {
                                $break_times= 0.5;
                            }else{
                                $break_times=0;
                            }
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

                    $average_enterance_hour=str_pad($average_enterance_hour, 2, "0", STR_PAD_LEFT);
                    $average_enterance_minute=str_pad($average_enterance_minute, 2, "0", STR_PAD_LEFT);
                    $average_enterance_second=str_pad($average_enterance_second, 2, "0", STR_PAD_LEFT);


//                    if ($average_enterance_hour<10 && strlen($average_enterance_hour)<2){
//                        $average_enterance_hour="0".$average_enterance_hour;
//                    }
//                    if ($average_enterance_minute<10&& strlen($average_enterance_minute)<2){
//                        $average_enterance_minute="0".$average_enterance_minute;
//                    }
//                    if ($average_enterance_second<10&& strlen($average_enterance_second)<2){
//                        $average_enterance_second="0".$average_enterance_second;
//                    }
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
                    $average_exit_hour=str_pad($average_exit_hour, 2, "0", STR_PAD_LEFT);
                    $average_exit_minute=str_pad($average_exit_minute, 2, "0", STR_PAD_LEFT);
                    $average_exit_second=str_pad($average_exit_second, 2, "0", STR_PAD_LEFT);
//                    if ($average_exit_hour<10){
//                        $average_exit_hour="0".$average_exit_hour;
//                    }
//                    if ($average_exit_minute<10){
//                        $average_exit_minute="0".$average_exit_minute;
//                    }
//                    if ($average_exit_second<10){
//                        $average_exit_second="0".$average_exit_second;
//                    }
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
                        if ($key < ($count - 1)) {
                            if ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>='12:00:00' && $calculations[$key + 1]->time<='13:00:00') {
                                $calculations[$key+1]->time='12:00:00';
                            }
                            //reset 18:00:00
                            if ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>'18:00:00' && $calculations[$key + 1]->time<'18:30:00') {
                                $y = strtotime('18:00:00');
                            }else{
                                $y = strtotime($calculations[$key + 1]->time);
                            }
                            if ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>'18:30:00') {
                                $break_time= -0.5;
                            }else{
                                $break_time=0;
                            }
                            $x = strtotime(($value->time));
                            $y = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                $z = (($y - $x) / 3600)+$break_time;
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
                    if ($value->status == '退室' && $value->company == '出側') {
                        if ($key < ($count - 1)) {
                            if ( $calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側' && $calculations[$key + 1]->time>'12:00:00' && $calculations[$key + 1]->time<'13:00:00') {
                                $calculations[$key+1]->time='13:00:00';
                                continue;
                            }
                            if ( $calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側' && $calculations[$key + 1]->time>'18:00:00' && $calculations[$key + 1]->time<'18:30:00') {
                                $b = strtotime('18:30:00');
                            }else{
                                $b = strtotime($calculations[$key + 1]->time);
                            }
                            if ( $calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側'  && $calculations[$key + 1]->time>'18:30:00') {
                                $break_times= 0.5;
                            }else{
                                $break_times=0;
                            }
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
                ->select(DB::raw('created_at,time(created_at) as time,day(created_at) as day,month(created_at) as month,card_holder,card_number,status,company'))
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
        $avg_entrance_hour=0.0;
        $avg_entrance_minute=0.0;
        $avg_entrance_second=0.0;
        $count2=1;
        $average_hour=0;
        $average_minute=0;
        $average_second=0;
        foreach ($calculations as $key => $value) {
//            var_dump(strtotime('18:00:00')/3600);
//            if ($value->time> '18:00:00' ){
            var_dump($value->time);
//            echo "<br>";
//                var_dump($value->day);
//                if ( !($value->time> '18:00:00' && $value->time < '18:30:00')) {
//                                    var_dump($z);
////                    $sumin = ($sumin+$z)+0.5;
////                continue;
//                }
//            }
//            var_dump(strtotime('13:00:00')/3600);
            if ($key < ($count - 1)) {
                if ($everyday_first_data_flg === 1) {
                    $enter_time = $value->time;
                    $a = preg_split('/[: ]/', $enter_time);
                    $hour = $a[0];
                    $minute = $a[1];
                    $second = $a[2];
                    if ($hour < 10) {
                        $avg_entrance_hour = $avg_entrance_hour + $hour;
                        $avg_entrance_minute = $avg_entrance_minute + $minute;
                        $avg_entrance_second = $avg_entrance_second + $second;
                        $average_hour = floor($avg_entrance_hour / $count2);
                        $average_minute = round($avg_entrance_minute / $count2) + round(60 * ($avg_entrance_hour / $count2 - $average_hour));
                        $average_second = round($avg_entrance_second / $count2);
                        if ($average_second > 59) {
                            $average_minute = $average_minute + 1;
                            $average_second = $average_second - 60;
                        }
                        if ($average_minute > 59) {
                            $average_hour = $average_hour + 1;
                            $average_minute = $average_minute - 60;
                        }
                        $count2++;
                    }
                    $average_hour = str_pad($average_hour, 2, "0", STR_PAD_LEFT);
                    $average_minute = str_pad($average_minute, 2, "0", STR_PAD_LEFT);
                    $average_second = str_pad($average_second, 2, "0", STR_PAD_LEFT);
                    $average_entrance = $average_hour . ":" . $average_minute . ":" . $average_second;
                }
                if ($value->card_number != $calculations[$key + 1]->card_number || $value->day != $calculations[$key + 1]->day) {
                    $everyday_first_data_flg = 1;
                } else {
                    $everyday_first_data_flg = 0;
                }
                // reset ( every day )
                if ($value->day !== $calculations[$key + 1]->day) {
                    $list2[] = array('time' => $value->time, 'month' => $value->month, "day" => $value->day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout, "enter" => $average_entrance, "exit" => $calculations[$key]->time);
                    $everyday_first_data_flg = 1;
                    //        var_dump($valuelist);
                    $sumin = 0.0;     // Intializing the time total that the employee stayed in office
                    $sumout = 0.0;     // Intializing the time total that the employee stayed outside the office
                    $minutein = 0.0;
                    $minuteout = 0.0;

                }
//                    $current = strtotime($value->time) / 3600.0;
                // enter 12:00 - 13:00
//                    if ($value->status == '入室' && $value->company == '入側' && $value->time > '12:00:00' && $value->time < '13:00:00') {
////                        var_dump($value->time);
////                        var_dump("value<br/>");
////
////                        var_dump($calculations[$key+1]->time);
//                        $value->time = '13:00:00';
//
//                    }
////                     exit 12:00 - 13:00
//                    elseif ($value->status == '退室' && $value->company == '出側' && $value->time > '12:00:00' && $value->time < '13:00:00') {
////                        var_dump($value->time);
//
////                        $value->time = '12:00:00';
//                        $calculations[$key+1]->time='12:00:00';
////                        var_dump();
////                        continue;
//                    }
                if ($value->day == $calculations[$key + 1]->day) {
                    if ($value->status == '入室' && $value->company == '入側') {
                        if ($key < ($count - 1)) {
                            //uchida try ----------
                            //echo(nl2br("\n"));
//                            echo("\n");
                            if ($calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time > '11:59:00' && $calculations[$key + 1]->time <= '13:00:00') {
//                                var_dump($calculations[$key+1]->time);
                                $calculations[$key + 1]->time = '12:00:00';
//                                var_dump($calculations[$key+1]->time);
//                                continue;
//                                var_dump($calculations[$key+1]->time);
                            }
                            if ($value->time < $calculations[$key + 1]->time) {
//                            echo("CALC: ".$calculations[$key + 1]->time ." - ".$value->time."<br/>");

//                                continue;


//                                echo "uchida";
                                //reset 18:00:00
                                if ($calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time > '18:00:00' && $calculations[$key + 1]->time < '18:30:00') {
//                                echo "uchida";
                                    $y = strtotime('18:00:00');
                                } else {
                                    $y = strtotime($calculations[$key + 1]->time);
                                }
                                //uchida try ----------
                                if ($calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time > '18:30:00') {
                                    $break_time = -0.5;
//                                var_dump($calculations[$key + 1]->time);
                                } else {
                                    $break_time = 0;
                                }
                                $count_value1 = count($calculations[$key + 1]->time);
                                if (($calculations[$key + 1]->time >= '12:00:00' && $calculations[$key + 1]->time <= '13:00:00') && ($value->time >= '12:00:00' && $value->time <= '13:00:00')) {

//                                var_dump($count_value1);
//                                if($count_value1==1){
//                                    var_dump($value->time."Cal".$calculations[$key + 1]->time);
//                                continue;
//                                    $lunch1=-1;
//                                }
//                                else{
//                                    continue;
//                                }

                                }
                            }
//                            else{
//                                $lunch1=0;
//                            }

                            $x = strtotime(($value->time));
//                            $current=$x/3600.0;
//                            $next=$y/3600.0;
//                            if($next>=413436 && $next<=413437) {
//                                $y=strtotime('12:00:00');
//                            }
//                            echo("CALC: ".$calculations[$key + 1]->time ." - ".$value->time."\n");

                            if ($value->day == $calculations[$key + 1]->day) {
                                $z = (($y - $x) / 3600) + $break_time;
                            }
//                            var_dump($break_time);
                            $sumin = ($sumin + $z);
//                            var_dump($sumin);

                            $hoursin = floor($sumin);
                            $minutein = round(60 * ($sumin - $hoursin));
                            if ($minutein > 59) {
                                $hoursin = $hoursin + 1.0;
                                $minutein = $minutein - 60.0;
                            }

                        }
                    }
                }

                if ($value->day == $calculations[$key+1]->day) {
                    if ($value->status == '退室' && $value->company == '出側') {
                        if($key < ($count-1) ){

                            if ( ($calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側')&& ($calculations[$key + 1]->time>'11:59:00' && $calculations[$key + 1]->time<'13:00:00')) {
//                                var_dump($calculations[$key+1]->time);
                                $calculations[$key+1]->time='13:00:00';
//                                $value->time='12:00:00';
                                continue;

//                                var_dump($calculations[$key+1]->time);
//                                var_dump($value->time);
//                                echo("CALC: ".$calculations[$key + 1]->time ." - ".$value->time."\n");
                            }
                            if($value->time <$calculations[$key+1]->time) {
//                                echo("CALC: " . $calculations[$key + 1]->time . " - " . $value->time . "<br/>");

//                                continue;


//                            if ($value->status == '退室' && $value->company == '出側' && $value->time > '12:00:00' && $value->time < '13:00:00') {
//        //                        var_dump($value->time);
//
//                                //                        $value->time = '12:00:00';
//                                $calculations[$key+1]->time='12:00:00';
//                                //                        var_dump();
//                                                        continue;
//                         }

                                if ($calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側' && $calculations[$key + 1]->time > '18:00:00' && $calculations[$key + 1]->time < '18:30:00') {
//                            echo "shume";
                                    $b = strtotime('18:30:00');
                                } else {
                                    $b = strtotime($calculations[$key + 1]->time);
                                }
                                if ($calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側' && $calculations[$key + 1]->time > '18:30:00') {
                                    $break_times = -0.5;
                                    var_dump($value->time."<br/>");
                                } else {
                                    $break_times = 0;
                                }
                                $count_value = count($calculations[$key + 1]->time);
                                if (($calculations[$key + 1]->time >= '12:00:00' && $calculations[$key + 1]->time <= '13:00:00') && ($value->time >= '12:00:00' && $value->time <= '13:00:00')) {

//                                var_dump($count_value);
//                                if($count_value==1){
////                                   var_dump($value->time."Cal".$calculations[$key + 1]->time);
////                                continue;
                                    $lunch = -1;
//                               }
//                               else{
                                    continue;
                                } //                            }
                                else {
                                    $lunch = 0;
                                }
                            }
                            $a = strtotime(($value->time));
                            $b = strtotime($calculations[$key + 1]->time);
//                            $current=$a/3600.0;
//                            $next=$b/3600.0;
//                            echo "<br/>";

                            $f = (($b - $a) / 3600);
                            $sumout += $f;
//                            var_dump($sumout);

                            $hoursout = floor($sumout);


                            $minuteout = round(60 * ($sumout - $hoursout));
//                            var_dump($minuteout);
                            if ($minuteout>60){
                                $hoursout=$hoursout+1;
                                $minuteout=$minuteout-60;
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
        $list2[] = array('time'=>$value->time,'month' => $last_month, "day" => $last_day, "sumin" => $hoursin, "minutein" => $minutein, "sumout" => $hoursout, "minuteout" => $minuteout,"enter"=>$enter_time,"exit"=>$last_time,"card_holder"=>$value->card_holder,"average_enterance"=>$average_entrance);

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
                            if ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>='12:00:00' && $calculations[$key + 1]->time<='13:00:00') {
//                                var_dump($calculations[$key+1]->time);
                                $calculations[$key+1]->time='12:00:00';
//                                var_dump($calculations[$key+1]->time);
                            }
//                                echo "uchida";
                            //reset 18:00:00
                            if ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>'18:00:00' && $calculations[$key + 1]->time<'18:30:00') {
//                                echo "uchida";
                                $y = strtotime('18:00:00');
                            }else{
                                $y = strtotime($calculations[$key + 1]->time);
                            }
                            //uchida try ----------
                            if ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>'18:30:00') {
                                $break_time= -0.5;
//                                var_dump($calculations[$key + 1]->time);
                            }else{
                                $break_time=0;
                            }

                            $x = strtotime(($value->time));
                            $y = strtotime($calculations[$key + 1]->time);
                            if ($value->day == $calculations[$key + 1]->day) {
                                $z = (($y - $x) / 3600)+$break_time;
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
                            if ( $calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側' && $calculations[$key + 1]->time>'12:00:00' && $calculations[$key + 1]->time<'13:00:00') {
//                                var_dump($calculations[$key+1]->time);
                                $calculations[$key+1]->time='13:00:00';
                                continue;
//                                var_dump($calculations[$key+1]->time);
//                                var_dump($value->time);

                            }

                            if ( $calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側' && $calculations[$key + 1]->time>'18:00:00' && $calculations[$key + 1]->time<'18:30:00') {
//                            echo "shume";
                                $b = strtotime('18:30:00');
                            }else{
                                $b = strtotime($calculations[$key + 1]->time);
                            }
                            if ( $calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側'  && $calculations[$key + 1]->time>'18:30:00') {
                                $break_times= 0.5;
                            }else{
                                $break_times=0;
                            }
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




if ($value->status == '入室' && $value->company == '入側') {
    if ($key < ($count - 1)) {
//                            var_dump("May".$calculations[$key+1]->time);
        if ($value->status==$calculations[$key+1]->status || $value->company==$calculations[$key+1]->company){
            $value->status=$calculations[$key+1]->status;
            $value->company=$calculations[$key+1]->company;
//                                continue;
        }
        //uchida
        if (  $value->time > '11:59:00'
                && $value->time <= '13:00:00') {
            $value->time='13:00:00';
            $lunch_flag=1;

        }elseif ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>'11:59:00' && $calculations[$key + 1]->time<='13:00:00') {

            $calculations[$key+1]->time='12:00:00';
            $lunch_flag=1;

        }


        if ($calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time > '18:00:00' && $calculations[$key + 1]->time < '18:30:00') {
            $y = strtotime('18:00:00');
            $evening_break=1;
        }
        else {
            $y = strtotime($calculations[$key + 1]->time);
        }
//                            if($calculations[$key + 1]->time > '18:00:00' && $calculations[$key + 1]->time < '18:30:00'){
//                                if(isset($calculations[$key + 1]->time)){
//
//                                }
//                            }

//                            if($value->card_number=="0000000000201401") {
//                                var_dump("Before sumin    ".$sumin."(".$hoursin."....".$minutein.")......"."Z=".$z." Day".$value->day);
//                                echo "<br />";
//
//                            }


//                            if($value->card_number=="0000000000000003") {
//                                var_dump("T sumin".$sumin."..."."Z=".$z." Day".$value->day);
//                                echo "<br />";
//                            }

        // Uchida Check1
        if($value->card_number=="0000000000000003") {
            var_dump("Uchida Check1 :  next=".$calculations[$key + 1]->time." .... this=".$value->time);
            echo "<br />";
        }

        $x = strtotime(($value->time));
        $z = (($y - $x) / 3600) ;

        $sumin = $sumin + $z;
        if($value->card_number=="0000000000000003") {
            var_dump("A sumin".$sumin."..."."Z=".$z." Day".$value->day);
            echo "<br />";
        }

//21

//                            if($value->card_number=="0000000000201401") {
//                                var_dump("B sumin".$sumin."..."."Z=".$z." Day".$value->day);
//                                echo "<br />";
//                            }


//                            $second=round(60*((60 * ($sumin - $hoursin)-$minutein)));

//                            if($value->card_number=="0000000000201401") {
//                                var_dump("After sumin    ".$hoursin."....".$minutein."......."."Z=".$z." Day".$value->day);
//                                echo "<br />";
//
//                            }

//                            var_dump("let22    ".$hoursin."....".$minutein.".......".$value->day);
//                            echo "<br />";



//                            if ( $calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time>'11:59:00' && $calculations[$key + 1]->time<='13:00:00') {
//                                $calculations[$key+1]->time='12:00:00';
//                                $lunch_flag=1;
//                            }
//                        if ($calculations[$key + 1]->time > '18:00:00' ){
//                            if ($calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time > '18:00:00' && $calculations[$key + 1]->time < '18:30:00') {
////                                $y = strtotime('18:00:00');
//                                $calculations[$key+1]->time='18:00:00';
//                                $evening_break = 1;
////                                $y= $calculations[$key+1]->time;
////                                continue;
//                            }
//                            else {
////                                $y = strtotime($calculations[$key + 1]->time);
//                                if ($calculations[$key + 1]->status == '退室' && $calculations[$key + 1]->company == '出側' && $calculations[$key + 1]->time >='18:30:00') {
//
//                                }
//                            }
//                        }
//                            if($calculations[$key + 1]->time >='18:00:00' && $calculations[$key + 1]->time <='18:30:00'){
////                                continue;
//                                    $break_time_evening1=-0.5;
//
//                            }
//                            else{
//                                $break_time_evening1=0;
//                            }
//
//
//                            $y = strtotime($calculations[$key + 1]->time);
//                            $x = strtotime(($value->time));
//                            $z = (($y - $x) / 3600);
//                            $sumin = ($sumin + $z)+$break_time_evening1;
//                            $hoursin = floor($sumin);
//                            $minutein = round(60 * ($sumin - $hoursin));
////                            $second=round(60*((60 * ($sumin - $hoursin)-$minutein)));
////                        var_dump($minutein."....".$second.".......".$value->day);
//                            if ($minutein > 59) {
//                                $hoursin = $hoursin + 1.0;
//                                $minutein = $minutein - 60.0;
//                            }
    }

}

//sumout21
if ($value->status == '退室' && $value->company == '出側') {
    if ($key < ($count - 1)) {
        if($value->time <$calculations[$key+1]->time) {

            //uchida
            if ( ($calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側')
                    && ($calculations[$key + 1]->time>'11:59:00' && $calculations[$key + 1]->time<'13:00:00')
                    && ($value->time < '12:00:00')) {
                $calculations[$key+1]->time='12:00:00';
                $sumout=(strtotime($calculations[$key+1]->time)-strtotime($value->time))/3600;
                if($value->card_number=="0000000000000003") {
                    var_dump($calculations[$key+1]->time." -minus  ".$value->time."sumout  ".$sumout);
                    echo "<br />";
                }

//                                    $lunch_flag=1;
                //                                    continue;
            }
            elseif ( ($calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側')&& ($calculations[$key + 1]->time>'11:59:00' && $calculations[$key + 1]->time<'13:00:00')) {
                $calculations[$key+1]->time='13:00:00';
                $lunch_flag=1;
                //                                    continue;
            }

            if ($calculations[$key + 1]->status == '入室' && $calculations[$key + 1]->company == '入側' && $calculations[$key + 1]->time > '18:00:00' && $calculations[$key + 1]->time < '18:30:00') {

                $calculations[$key+1]->time='18:30:00';
                //                                $b = strtotime('18:30:00');

            } else {
                //                                $b=$calculations[$key+1]->time;
                if ($calculations[$key+1]->time=='13:00:00' && $value->time=='12:00:00'){

                    $lunch=-1;
                    continue;
                }
                else{
                    $lunch=0;
                }
            }
            if($calculations[$key + 1]->time >='18:00:00' && $calculations[$key + 1]->time <='18:30:00'){
                $break_time_evening=-0.5;
                continue;
                //

            }else{
                $break_time_evening=0;
            }

            // Uchida Check 2
            if($value->card_number=="0000000000000003") {
                var_dump("Uchida Check2 :  next=".$calculations[$key + 1]->time." .... this=".$value->time);
                echo "<br />";
            }

            $a = strtotime(($value->time));
            $b = strtotime($calculations[$key + 1]->time);
            $f = (($b - $a) / 3600)+$lunch;
            $sumout += $f;
            $hoursout = floor($sumout);
            $minuteout = round(60 * ($sumout - $hoursout));
            if ($minuteout>59){
                $hoursout=$hoursout+1;
                $minuteout=$minuteout-60;
            }
        }
    }
}