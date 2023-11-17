<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobForm;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;
use Carbon\Carbon;

class JobController extends Controller
{
    public function addjob(request $request){
        $rules = [
    		'customer_name'        => 'required',
            'service_titan_number' => 'required',
            'dispatch_time'        => 'required|date_format:Y-m-d H:i:s',
        ];
        //echo $request->user()->id;die;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $job = Job::create([
            'customer_name'        => $request->customer_name,
            'service_titan_number' => $request->service_titan_number,
            'dispatch_time'        => $request->dispatch_time,
            "user_id"              => $request->user()->id
        ]);

        return returnSuccessResponse('Job created successfully.', $job);
        

    }

    public function updateJob(request $request,$jobId){
        $rules = [
            'arrival_time' => 'sometimes|date_format:Y-m-d H:i:s',
            'checkout_time' => 'required_without:arrival_time|date_format:Y-m-d H:i:s',
            'total_hours' => 'required_with_all:checkout_time'
        ];
        //echo "<pre>";print_r($request->all());die;
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
        
        $job = Job::where("id",$jobId)->first();
        
        if($job){
            
            if ($request->has('arrival_time')) {
               
                $job->arrival_time = $request->arrival_time;
            }
    
            if ($request->has('checkout_time')) {
                $job->checkout_time = $request->checkout_time;
                $job->total_hours = $request->total_hours;
            }        
            
            $job->save();
    
            return returnSuccessResponse('Job updated successfully.', $job);
        }else{
            return returnErrorResponse('Job  not found.');
        }

        
        

    }

    public function addjobForm(request $request){
        $rules = [
            'id'                   => 'sometimes|exists:job_forms',
            'service_titan_number' => 'required',
            'total_amount'         => 'required|numeric',
            'comission'           => 'required|numeric',
            'job_id'               => 'required|numeric',   
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        if ($request->has('id')) {
            
            $jobForm = JobForm::find($request->input('id'));

            if (!$jobForm) {
                return response()->json(['message' => 'JobForm not found'], 404);
            }

            $jobForm->update([
                'service_titan_number' => $request->service_titan_number,
                'total_amount'         => $request->total_amount,
                'comission'           => $request->comission,
            ]);
            return returnSuccessResponse('JobForm updated successfully.', $jobForm);
            
        } else {
            
            $jobForm = JobForm::create([
                'service_titan_number' => $request->service_titan_number,
                'total_amount'         => $request->total_amount,
                'comission'           => $request->comission,
                'job_id'               => $request->job_id,
                'user_id'             => $request->user()->id
            ]);
            return returnSuccessResponse('JobForm created successfully.', $jobForm);
            
        }
    }

    public function jobHistory(Request $request){
        $userId = $request->user()->id;

        $jobs = Job::where('user_id', $userId)->with('jobForm')->orderBy("id","desc")->get();

        return returnSuccessResponse('Job history found.', $jobs);
    }
}
