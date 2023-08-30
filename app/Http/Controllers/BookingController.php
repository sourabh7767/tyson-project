<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;

class BookingController extends Controller
{
    public function showBooking($id){
        $events = [];
        return view('booking.index',compact("events"));
    }

    public function addBooking($id,request $request){
        $slotsData = TimeSlot::where("company_id",$id)
        //->whereDate("start_date_time",date("Y-m-d"))
        ->get();
        //echo "<pre>";print_r($slotsData->toArray());die;
        return view('booking.add',compact('slotsData'));
    }

    public function storeBooking($id,request $request){
        
    }
}
