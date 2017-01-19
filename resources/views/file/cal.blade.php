
@if($customers2)
@foreach($customers2 as $customer)
{{$customer}}
@endforeach

    @endif

{{--Excel::load(storage_path('app/public/excel-import.xlsx'), function($reader) {--}}

{{--$results = $reader->get();--}}
{{--foreach($results as $result) {--}}
{{--// Your model namespace here--}}
{{--$model = new \App\ImportItem();--}}
{{--$model->region_code = $result->region;--}}
{{--$model->numeric_code = $result->code;--}}
{{--$model->testfield = $result->test_field;--}}
{{--$model->save();--}}
{{--}--}}
{{--});--}}




//            $path = Input::file('upload')->getRealPath();
//            $data = Excel::load($path, function($reader) {
//
//            })->get();
//            if (!empty($data) && $data->count()) {
//                $count = 0;
//                foreach ($data as $key => $value) {
//                    $insert = array();
////                    $insert['name'] = $value->name;
//                    $this->Customer->create($insert);
//                }
//            }

//        $import=Input::file('upload');
////        Excel::filter('chunk')->noHeading()->load($import)->chunk(250, function($reader){
////        Excel::load($import, function ($reader) {
//        Excel::load($import)->byConfig('excel::import.sheets', function($reader) {
//
////           mb_convert_encoding((string)$reader, "SHIFT-JIS","UTF-8");
//
//            $created_at=$reader->created_at;
//            var_dump("Created at ".$created_at);
//            $in=$reader->in;
//            $out=$reader->out;
//            $door=$reader->door;
//            $status=$reader->status;
//            var_dump("status ".$status);
//
//            $company=$reader->company;
//            $status2=$reader->status2;
//            $company2=$reader->company2;
//            $card_number=$reader->card_number;
//            $card_holder=$reader->card_holder;
//
////
////            $reader->noHeading();
////            $reader->formatDates(true);
//
//            $reader->each(function ($sheet) {
////                var_dump($sheet->first());
////
//                var_dump($sheet[0]);
//////                echo("<br />");
////                $sheet0=$sheet[0];
////                $sheet1= $sheet[1];
////                $sheet2= $sheet[2];
////                $sheet3=$sheet[3];
////                $sheet4=$sheet[4];
////                $sheet5=$sheet[5];
////                $sheet6=$sheet[6];
////                $sheet7=$sheet[7];
////                $sheet8=$sheet[8];
////                $sheet9=$sheet[9];
////                var_dump("created_at: ".$sheet3);
////                echo("<br />");
//                var_dump("in: ".$sheet[1]);
////                echo("<br />");
////                var_dump("out : ".$sheet[2]);
////                echo("<br />");
////                var_dump("door: ".$sheet[3]);
////                echo("<br />");
////                var_dump("status : ".$sheet[4]);
////                echo("<br />");
////                var_dump("company : ".$sheet[5]);
////                echo("<br />");
////                var_dump("status2 : ".$sheet[6]);
////                echo("<br />");
////                var_dump("company2 : ".$sheet[7]);
////                echo("<br />");
////                var_dump("card_number : ".$sheet[8]);
////                echo("<br />");
////                var_dump("card_holder : ".$sheet[9]);
////                echo("<br />");
////                echo("<br />");
////                echo("<br />");
////                $sheet->noHeading();
////                var_dump($sheet);
//                $customers = Customer::firstOrCreate($sheet->toArray());
//
//
////                var_dump($customers);
//            }, 'shift_jis')->all();
//        });
//
//        return redirect('/home');
//        $path =Input:: file('upload');
//        $data = Excel::load($path, function ($reader) {
//        },'shift_jis')->get();
////        var_dump($data);
//
//        if (!empty($data) && count($data)) {
//            $insert=array();
//
//            foreach ($data->toArray() as $key => $value) {
////                var_dump($value[2]);
//
//                if (!empty($value)) {
//                    foreach ($value as $v) {
//                        $insert[] = ['created_at' => $data[0], 'in' => $data[1], 'out' => $data[2], 'status' => $data[3],'company' => $data[4], 'door' => $data[5], 'status2' => $data[6], 'company2' => $data[7], 'card_number' => $data[8], 'card_holder' => $data[9]];
//
//                    }
//                }
//            }
//
//
//            if (!empty($insert)) {
//                Customer::insert($insert);
//                return back()->with('success', 'Insert Record successfully.');
//            }
//
//        }
//
//
//        return back()->with('error', 'Please Check your file, Something is wrong there.');
