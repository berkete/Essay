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