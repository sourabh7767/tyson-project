<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TripDataController extends Controller
{
    public function start(Request $request) {
        // Validate the request based on type (start or close)
        $rules = [
            'type' => 'required|in:1,2,3', // 1 for start, 2 for close
            // 'user_id' => 'required_if:type,1|integer', // Required if starting a trip
            // 'id' => 'required_if:type,2|integer', // Required if closing a trip
        ];
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
        
        if (empty($request->id)) {
            if(DB::table('trip_data')->where('user_id',$request->user()->id)->where('end_time',null)->exists()){
                return returnErrorResponse('You already have an ongoing trip,stand by, or in meeting!');
            }
            if($request->type == TYPR_TRIP){
                $message = "Trip started successfully";
            }elseif($request->type == TYPE_STAND_BY){
                $message = "On stand by.";
            }elseif($request->type == TYPE_MEETING){
                $message = "Meeting started successfully";
            }
            // $message = 
            // Start the trip: Insert new trip data
            $id = DB::table('trip_data')->insertGetId([
                'type' => $request->type,
                'user_id'       => $request->user()->id,
                'start_lat'     => $request->start_lat,
                'start_long'    => $request->start_long,
                'start_address' => $request->start_address,
                'start_time'    => now(), // Record start time as current time
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
    
            return returnSuccessResponse($message, $id);
    
        } elseif (!empty($request->id)) {
            if($request->type == TYPR_TRIP){
                $message = "Trip Closed successfully";
            }elseif($request->type == TYPE_STAND_BY){
                $message = "Removed from stand by.";
            }elseif($request->type == TYPE_MEETING){
                $message = "Meeting Closed successfully";
            }
            // Close the trip: Update existing trip with end time and calculate total hours
            $trip = DB::table('trip_data')->where('id', $request->id)->first();
            if(!empty($trip->end_time)){
                return returnErrorResponse('Already ended!');
            }
            if (!$trip) {
                return returnValidationErrorResponse("Trip not found");
            }
    
            // Calculate total hours (difference between start and end times)
            $endTime = now();
            $totalHours = getTimeDifference($endTime,$trip->start_time);
            // Update trip with end time, location, and total hours
            DB::table('trip_data')->where('id', $request->id)->update([
                'end_lat'       => $request->end_lat,
                'end_long'      => $request->end_long,
                'end_address'   => $request->end_address,
                'end_time'      => $endTime,
                'total_hours'   => $totalHours,
                'updated_at'    => now(),
            ]);
    
            return returnSuccessResponse($message, $request->id);
        }
    }
    
}
