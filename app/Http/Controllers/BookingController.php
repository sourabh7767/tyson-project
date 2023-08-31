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
                $data[] = ["title" => "test",
                            "start"=> $value->start_date_time,
                            "end"=> $value->end_date_time,
                            ];
            }
        }else{
            $data = [];
        }
        //echo "<pre>";print_r($data);die;
        $events = [];
        return view('booking.index',compact("data",'events'));
    }

    public function addBooking($id,request $request){
        $slotsData = TimeSlot::where("company_id",$id)
        ->whereDate("start_date_time",date("Y-m-d"))
        ->get();
        //echo "<pre>";print_r($slotsData->toArray());die;
        return view('booking.add',compact('slotsData',"id"));
    }

    public function storeBooking(request $request){
        $rules = array(
        'day' => 'required',
           'slot' => 'required',
           'no_of_slots' => 'required',
           'csr_name' => 'required',
           'job_number' => 'required',        
       );

       $message = [];
       $validator = Validator::make($request->all(), $rules,$message);
       if ($validator->fails()) {
           return Redirect::back()->withInput()->withErrors($validator);
       }  

       $model =  new Booking();
       $model->company_id = $request->company_id;
       $model->slot_id = $request->slot;
       $model->start_date_time = $request->day;
       $model->end_date_time = $request->day;
       $model->csr_name = $request->csr_name;
       $model->time_of_booking = date("Y-m-d");
       $model->job_number = $request->job_number; 
       $model->user_id = $request->user()->id;
       if(!$model->save()){
        return redirect()->back()->with('error', 'Unable to create booking. Please try again later.');
        }
        TimeSlot::where("id",$request->slot)->update(['remaining_slots' => DB::raw("GREATEST(remaining_slots - $request->no_of_slots, 0)")]);

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
}
