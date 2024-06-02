<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EditJob;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobForm;
use App\Models\JobFormPlumbing;
use App\Models\JobFormTechnician;
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
            'dispatch_address'     => @$request->address,
            'dispatch_lat'         => @$request->lat,
            'dispatch_long'        => @$request->long,
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
                $job->arrival_address     = @$request->address;
                $job->arrival_lat         = @$request->lat;
                $job->arrival_long        = @$request->long;
            }
    
            if ($request->has('checkout_time')) {
                $job->checkout_time = $request->checkout_time;
                $job->checkout_address     = @$request->address;
                $job->checkout_lat         = @$request->lat;
                $job->checkout_long        = @$request->long;
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
            'comission'            => 'required|numeric',
            "comission_amount"     => 'sometimes|numeric',
            'job_id'               => 'required|numeric',
            // 'is_lead'              => 'required_with:id'  
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
                'comission'            => $request->comission,
                'comission_amount'     => $request->comission_amount,
                'job_form_type'        => $request->job_form_type,
                'is_lead'              => empty($request->is_lead) ? $jobForm->is_lead : $request->is_lead,

            ]);
            return returnSuccessResponse('JobForm updated successfully.', $jobForm);
            
        } else {
            
            $jobForm = JobForm::create([
                'service_titan_number' => $request->service_titan_number,
                'total_amount'         => $request->total_amount,
                'comission'           => $request->comission,
                'job_id'               => $request->job_id,
                'user_id'             => $request->user()->id,
                'comission_amount'     => $request->comission_amount,
                'job_form_type'        => $request->job_form_type
            ]);
            return returnSuccessResponse('JobForm created successfully.', $jobForm);
            
        }
    }

    public function addjobFormPlumbing(request $request){
        $rules = [
            'id'                   => 'sometimes|exists:job_forms',
            'service_titan_number' => 'required',
            'amount_collected'     => 'required|numeric',
            'amount_financed'      => 'required|numeric',
            'job_id'               => 'required|numeric',
            'i_sold_it'            => 'required',
            'i_did_it'             => 'required',
            'i_set_the_lead'       => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        if ($request->has('id')) {
            
            $jobForm = JobFormPlumbing::find($request->input('id'));

            if (!$jobForm) {
                return response()->json(['message' => 'Job Form Plumbing not found'], 404);
            }

            $jobForm->update([
                'service_titan_number' => $request->service_titan_number,
                'amount_collected'     => $request->amount_collected,
                'amount_financed'      => $request->amount_financed,
                'i_sold_it'            => $request->i_sold_it,
                'i_did_it'             => $request->i_did_it,
                'i_set_the_lead'       => $request->i_set_the_lead,

            ]);
            return returnSuccessResponse('Job Form Plumbing updated successfully.', $jobForm);
            
        } else {
            
            $jobForm = JobFormPlumbing::create([
                'service_titan_number' => $request->service_titan_number,
                'amount_collected'     => $request->amount_collected,
                'amount_financed'      => $request->amount_financed,
                'job_id'               => $request->job_id,
                'user_id'              => $request->user()->id,
                'i_sold_it'            => $request->i_sold_it,
                'i_did_it'             => $request->i_did_it,
                'i_set_the_lead'       => $request->i_set_the_lead,
            ]);
            return returnSuccessResponse('Job Form Plumbing created successfully.', $jobForm);
            
        }
    }

    public function addJobFormTechnician(request $request){
        $rules = [
            'id'                   => 'sometimes|exists:job_forms',
            'service_titan_number' => 'required',
            'job_total'            => 'required|numeric',
            'total_pay'            => 'required|numeric',
            'job_id'               => 'required|numeric',
            'vip_sold'             => 'required',
            'i_sold_it'            => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        if ($request->has('id')) {
            $jobForm = JobFormTechnician::find($request->input('id'));

            if (!$jobForm) {
                return response()->json(['message' => 'Job Form Technichian not found'], 404);
            }

            $jobForm->update([
                'service_titan_number' => $request->service_titan_number,
                'job_total'            => $request->job_total,
                'total_pay'            => $request->total_pay,
                'vip_sold'             => $request->vip_sold,
                'i_sold_it'            => $request->i_sold_it,

            ]);
            return returnSuccessResponse('Job Form Technichian updated successfully.', $jobForm);
            
        } else {
            $jobForm = JobFormTechnician::create([
                'service_titan_number' => $request->service_titan_number,
                'job_total'            => $request->job_total,
                'total_pay'            => $request->total_pay,
                'job_id'               => $request->job_id,
                'user_id'              => $request->user()->id,
                'vip_sold'             => $request->vip_sold,
                'i_sold_it'            => $request->i_sold_it,
            ]);
            return returnSuccessResponse('Job Form Technichian created successfully.', $jobForm);
            
        }
    }

    public function jobHistory(Request $request){
        $userId = $request->user()->id;
        if($request->has("status") && !empty($request->status)){
            $status = $request->status;
            $jobs = Job::where('user_id', $userId)->with('jobForm','editJobs')
            ->whereHas('jobForm', function ($query) use($status){

                $query->where('status', $status);

            })
            ->orderBy("id","desc");
        }else{
            $jobs = Job::where('user_id', $userId)->with('jobForm','editJobs')->orderBy("id","desc");
        }
        
        if($request->has("start_date") && !empty($request->start_date)){
            
            $endDate = date('Y-m-d', strtotime($request->end_date . ' +1 day'));
            $jobs = $jobs->whereBetween('dispatch_time',[$request->start_date,$endDate]);
        }
        $jobs = $jobs->get();
        return returnSuccessResponse('Job history found.', $jobs);
    }
    public function addComment(Request $request){
        $rules = [
            'job_id' => 'required',
            'comment' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
        $model = new EditJob();
        $model->job_id = $request->job_id;
        $model->user_id = $request->user()->id;
        $model->comment = $request->comment;
        $model->save();
        return returnSuccessResponse('Comment added successfully.', $model);
    }
}
