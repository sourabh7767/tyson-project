<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Models\Booking;
use DB;

class BookingController extends Controller
{
    public function showBooking($id){
        $events = Booking::where("company_id",$id)->with("companyData","slotData")->get();
        if(!$events->isEmpty()){
            foreach($events as $key => $value){
                $data[] = ["title" => $value->slotData->slot,
                            "start"=> $value->start_date_time,
                            "end"=> $value->end_date_time,
                            "id" => $value->id,
                            'extendedProps' => array(
                                'csr_name' => $value->csr_name,
                                "customer_name" => $value->customer_name,
                                'job_number' => $value->job_number,
                            )
                            ];
            }
        }else{
            $data = [];
        }
        //echo "<pre>";print_r($data);die;
        $events = [];
        return view('booking.index',compact("data",'events'));
    }

    public function showBookingCsr($id){
        $events = Booking::where("company_id",$id)->with("companyData","slotData")->get();
        if(!$events->isEmpty()){
            foreach($events as $key => $value){
                $data[] = ["title" => $value->slotData->slot,
                            "start"=> $value->start_date_time,
                            "end"=> $value->end_date_time,
                            "id" => $value->id,
                            'extendedProps' => array(
                                'csr_name' => $value->csr_name,
                                "customer_name" => $value->customer_name,
                                'job_number' => $value->job_number,
                            )
                            ];
            }
        }else{
            $data = [];
        }
        //echo "<pre>";print_r($data);die;
        $events = [];
        return view('booking.csr_index',compact("data",'events'));
    }

    public function addBooking($id,request $request){

        $slotsData = TimeSlot::where("company_id",$id)
        ->whereDate("start_date_time",date("Y-m-d"))
        ->get();

        $slotsDataTommorow = TimeSlot::where("company_id",$id)
        ->whereDate("start_date_time",date("Y-m-d",strtotime("+1 day")))
        ->get();

        $slotsDataThreeDay = TimeSlot::where("company_id",$id)
        ->whereDate("start_date_time",date("Y-m-d",strtotime("+3 day")))
        ->get();

        $slotsDataFourDay = TimeSlot::where("company_id",$id)
        ->whereDate("start_date_time",date("Y-m-d",strtotime("+4 day")))
        ->get();
        $week = "";
        $slotsData = [];
        if($request->has("week")){
            $week = $request->week;
            if($request->week == "current"){
                $today = now();
                
                $dateStrings = [];
                $slotsDataArr = $dates = [];

                for ($i = 0; $i <= 6; $i++) {
                    

                    

                    if ($i == 0) {
                        $dates[] = $dateToCheck = $today->format('Y-m-d');
                        $dateStrings[$dateToCheck] = 'Today';
                        $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$id)
                                            ->whereDate("start_date_time",$today)
                                                ->get();
                        $slotsData = TimeSlot::where("company_id",$id)
                                                ->whereDate("start_date_time",date("Y-m-d"))
                                                ->get();                        
                    } elseif ($i == 1) {
                        $dates[] = $dateToCheck = $today->addDay()->format('Y-m-d');
                        $dateStrings[$dateToCheck] = 'Tomorrow';
                        $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$id)
                                            ->whereDate("start_date_time",$dateToCheck)
                                                ->get();
                    } else {
                        $dates[] = $dateToCheck = $today->addDay()->format('Y-m-d');
                        $dateStrings[$dateToCheck] = '+' . $i . ' days';
                        $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$id)
                                            ->whereDate("start_date_time",$dateToCheck)
                                                ->get();
                    }
                    
                }    
            }else{
                $nextWeekStartDate = now()->addDays(7);
                $dateStrings = [];
                $dates = [];

                for ($i = 0; $i < 7; $i++) {
                    $dates[] = $dateToCheck = $nextWeekStartDate->addDay()->format('Y-m-d');
                    $dateStrings[$dateToCheck] = $dateToCheck;
                    $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$id)
                                            ->whereDate("start_date_time",$dateToCheck)
                                                ->get();
                    if($i == 0){
                        $slotsData = TimeSlot::where("company_id",$id)
                                                ->whereDate("start_date_time",$dateToCheck)
                                                ->get();                                                     

                    }                            
                }

                //echo "<pre>";print_r($dateStrings);die;
            }
        }else{
            $week = "current";
            $today = now();
            $dateStrings = [];
            $slotsDataArr = $dates = [];

            for ($i = 0; $i <= 6; $i++) {
                

                

                if ($i == 0) {
                    $dates[] = $dateToCheck = $today->format('Y-m-d');
                    $dateStrings[$dateToCheck] = 'Today';
                    $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$id)
                                        ->whereDate("start_date_time",$today)
                                            ->get();
                    $slotsData = TimeSlot::where("company_id",$id)
                                            ->whereDate("start_date_time",date("Y-m-d"))
                                            ->get();                                                
                } elseif ($i == 1) {
                    $dates[] = $dateToCheck = $today->addDay()->format('Y-m-d');
                    $dateStrings[$dateToCheck] = 'Tomorrow';
                    $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$id)
                                        ->whereDate("start_date_time",$dateToCheck)
                                            ->get();
                } else {
                    $dates[] = $dateToCheck = $today->addDay()->format('Y-m-d');
                    $dateStrings[$dateToCheck] = '+' . $i . ' days';
                    $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$id)
                                        ->whereDate("start_date_time",$dateToCheck)
                                            ->get();
                }
            }
        }
        
        //echo "<pre>";print_r($slotsDataArr);die;
        return view('booking.add',compact('slotsData',"id","slotsDataFourDay","slotsDataThreeDay","slotsDataTommorow","dateStrings","dates","slotsDataArr","week"));
    }

    public function storeBooking(request $request){
      //  echo "<pre>";print_r($request->all());die;
        $rules = array(
        'day' => 'required',
           'slot' => 'required',
          // 'no_of_slots' => 'required',
           'csr_name' => 'required',
           'job_number' => 'required',        
       );

       $message = [];
       $validator = Validator::make($request->all(), $rules,$message);
       if ($validator->fails()) {
           return Redirect::back()->withInput()->withErrors($validator);
       }  

       $slot = TimeSlot::where("id",$request->slot)->first();
       list($start_time, $end_time) = explode(' - ', $slot->slot);

        // Convert day and time to DateTime format
        $start_datetime = date('Y-m-d H:i:s', strtotime($request->day . ' ' . $start_time));
        $end_datetime = date('Y-m-d H:i:s', strtotime($request->day . ' ' . $end_time));

       $model =  new Booking();
       $model->company_id = $request->company_id;
       $model->slot_id = $request->slot;
       $model->start_date_time = $start_datetime;
       $model->end_date_time = $end_datetime;
       $model->customer_name = $request->customer_name;
       $model->csr_name = $request->csr_name;
       $model->time_of_booking = date("Y-m-d");
       $model->job_number = $request->job_number; 
       $model->user_id = $request->user()->id;
       if(!$model->save()){
        return redirect()->back()->with('error', 'Unable to create booking. Please try again later.');
        }
        TimeSlot::where("id",$request->slot)->update(['remaining_slots' => DB::raw("GREATEST(remaining_slots - 1, 0)")]);

        return redirect()->route('booking.add',$request->company_id)->with('success', 'Booking created successfully.');
    }

    public function getSlots(request $request){
        $slotsData = TimeSlot::where("company_id",$request->comapny_id)
                            ->whereDate("start_date_time",$request->day)
                            ->get();
        if ($slotsData->isEmpty()) {
            return response()->json(['status' => 'no_data']);
        }
        return view('booking.slot-options', compact('slotsData'));
    }

    public function getSlotsNumber(request $request){
        $slotsData = TimeSlot::where("id",$request->id)
        ->first();
        if (empty($slotsData) || $slotsData->remaining_slots == 0) {
            return response()->json(['status' => 'no_data']);
        }
        return view('booking.slot-number', compact('slotsData'));
    }

    public function cancelBooking(request $request){
        $rules = array(
            'eventId' => 'required',        
           );
    
           $message = [];
           $validator = Validator::make($request->all(), $rules,$message);
           if ($validator->fails()) {
               return Redirect::back()->withInput()->withErrors($validator);
           }  

           $data = Booking::where("id",$request->eventId)->first();
           if($data){
                TimeSlot::where("id",$data->slot_id)->update(["remaining_slots"=> DB::raw("GREATEST(remaining_slots + 1, 0)")]);
                $data->delete();
           }
           echo json_encode(['status' => 'success', 'message' => 'Event canceled successfully']);
           exit;
    }
}
