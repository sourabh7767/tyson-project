<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use App\Models\EditJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobForm;

use App\Exports\JobsExport;
use Maatwebsite\Excel\Facades\Excel;

class JobController extends Controller
{
    public function index(Request $request, Job $job)
    {
    	if ($request->ajax()) {

            $users = $job->getAllJobs($request);

            $totalJobs = Job::count();

            $search = $request['search']['value'];

            $setFilteredRecords = $totalJobs;

            if(!empty($search)){

            $setFilteredRecords = $job->getAllJobs($request,true);

           }
           if ($request->has("status") && !empty($request->status)){
                $setFilteredRecords = $job->getAllJobs($request,true);
            }
           if ($request->filled('selected_id')){
            $setFilteredRecords = $job->getAllJobs($request,true);
           }
           if ($request->filled('start_date') && $request->filled('end_date')) {
            $setFilteredRecords = $job->getAllJobs($request,true);
           }
            return datatables()->of($users)
                ->addIndexColumn()
                // ->addColumn('status', function ($user) {
                //       return  '<span class="badge badge-light-'.$user->getStatusBadge().'">'.$user->getStatus().'</span>';
                // })
                ->addColumn('dispatch_time', function ($user) {
                    return $user->dispatch_time;
                })
                ->addColumn('checkout_time', function ($user) {
                    return $user->checkout_time;
                })
                ->addColumn('status', function ($user) {
                    if($user->status == 1){
                        return "Pending";
                    }elseif($user->status == 2){
                        return "Warm leads";
                    }elseif($user->status == 3){
                        return "No Sale";
                    }elseif($user->status == 4){
                        return "No Contact";
                    }elseif($user->status == 5){
                        return "Cancelled";
                    }elseif($user->status == 6){
                        return "Sold";
                    }else{
                        return "";
                    }
                    
                })
                ->addColumn('status_val', function ($user) {
                    return $user->status;
                })
                ->addColumn('is_lead', function ($user) {
                    return $user->is_lead == 0 ?  "No" : "YES";
                })

                ->addColumn('action', function ($user) {
                $btn = '';
                $btn = '<a href="' . route('jobs.show',encrypt($user->id)) . '" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
                if($user->status){
                    $btn .= '<button class="edit-button" data-id="' . $user->id . '">Edit Here</button>&nbsp;&nbsp;';
                }
                
                
                // $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' .$user->id. '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';
                // $btn .= '<a href="' . route('user.changeUserPassword',encrypt($user->id)) . '" title="Change Password">Change password</a>&nbsp;&nbsp;';

                    return $btn;
                })
                ->rawColumns([
                'action',
                'status',
                'is_lead'
            ])->setTotalRecords($setFilteredRecords)->setFilteredRecords($setFilteredRecords)->skipPaging()
                ->make(true);
        }

        return view('jobs.index');
    }

    public function show(Request $request,$jobId)
    {
        if($request->ajax()){
            $model = Job::with('jobForm')->where('id', $jobId)->first();
            return response()->json(['job_data' => $model]);
        }

        $model = Job::with('jobForm','editJobs','user:id,role')->where('id', decrypt($jobId) )->first();
            return view('jobs.view',compact("model"));
    }

    public function updateJobStatus(request $request){
        $id = $request->id;
        $request->validate([
            'admin_comission_per' => [
                'sometimes',
                'required_if:job_status,6',
                // 'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'admin_comission_amount_per' => [
                'sometimes',
                'required_if:job_status,6',
                // 'regex:/^\d+(\.\d{1,2})?$/'
            ],
            ],[
              "admin_comission_per.required_if" => "The admin comission Percentage field is required"  ,
              "admin_comission_amount_per.required_if" => "The admin comission Amount field is required!",
            //   "admin_comission_per.regex" => "The admin comission Percentage field must be a number or decimal",
            //   "admin_comission_amount_per.regex" => "The admin comission Amount field must be a number or decimal"
            ]);
        $job = Job::find($id);

        if(!$job){
            return returnNotFoundResponse('This Job does not exist');
        }

        
        JobForm::where("job_id",$request->id)->update([
            "status"=>$request->job_status,
            "admin_comission_per" => $request->admin_comission_per,
            "admin_comission_amount_per" => $request->admin_comission_amount_per
        ]);

        return returnSuccessResponse('Status updated successfully');
    }

public function exportToExcel(Request $request)
{
    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');
    $selectedUsers = $request->input('selectedUsers');
    $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
    $export = new JobsExport($startDate, $endDate, $selectedUsers);
    
    return Excel::download($export, 'jobs.xlsx');
}
public function update(Request $request){
    
    //  dd($abc);
    // dd($configResult->access_token);
    $request->validate([
        'comment' => 'required',
        // 'total_amount' => 'required',
        // 'comission_per' => "required",
    ]);
    $newData = [
            "total_amount" => $request->total_amount,
            "comission_per" => $request->comission_per,
            "comission_amount" => $request->comission_amount,
            "dispatch_time" =>$request->dispatch_time,
            "arrival_time"=>$request->arrival_time,
            "checkout_time"=>$request->checkout_time,
        ];
        $existingRecord = JobForm::find($request->job_id);
        // if(empty($existingRecord)){
        //     session()->flash('error',"Job Form not added");
        //     return response()->json('error');
        // }
        $jobObj = Job::where('id',$request->job_id)->with('user:id,fcm_token,device_type')->first();
        $editJobObj = new EditJob();
        $oldData = [
            'jobForm' => !empty($existingRecord) ? $existingRecord->toArray() : "",
            'job' => [
                'dispatch_time' => $jobObj->dispatch_time,
                'arrival_time' => $jobObj->arrival_time,
                'checkout_time' => $jobObj->checkout_time,
            ]
        ];
        $editJobObj->user_id = auth()->user()->id;
        $editJobObj->job_id = $request->job_id;
        $editJobObj->new_data = json_encode($newData);
        $editJobObj->old_data = json_encode($oldData);
        $editJobObj->comment = $request->comment;
        if($editJobObj->save()){
            if(!empty($existingRecord)){
                $existingRecord->comission = !empty($request->comission_per) ? $request->comission_per : $existingRecord->comission;
                $existingRecord->total_amount = !empty($request->total_amount) ? $request->total_amount : $existingRecord->total_amount;
                $existingRecord->comission_amount = !empty($request->comission_amount) ? $request->comission_amount : $existingRecord->comission_amount;
                $existingRecord->save();
            }
            
            $jobObj->dispatch_time = !empty($request->dispatch_time) ? $request->dispatch_time : $jobObj->dispatch_time;
            $jobObj->arrival_time = !empty($request->arrival_time) ? $request->arrival_time : $jobObj->arrival_time;
            $jobObj->checkout_time = !empty($request->checkout_time) ? $request->checkout_time : $jobObj->checkout_time;
            // $diff = $this->getTimeDifference($request->dispatch_time,$request->checkout_time);
            // $jobObj->total_hours = $diff;
                
                // $jobObj->save();
                if($jobObj->save()){
                    
                }else{
                    session()->flash('error',"Job not Updated");
                    return response()->json('error');
                }
                $data['job_id'] = $jobObj->id;
                
                // $data['']
                // $this->sendPushNotification($jobObj->user->fcm_token,"Admin Comment","Admin Commented On your job",$jobObj->user->device_type,$data,0);
                if(!empty($jobObj->user->fcm_token)){
                    $configResult  = $this->fireBaseConfig();
                    $this->sendFireBasePushNotification($configResult->access_token,$jobObj->user->fcm_token,"Comment",$request->comment,$jobObj->id);
                }
            session()->flash('success',"Job Updated");
            return response()->json('success');
        }
}

public function getTimeDifference($startDateTime,$endDateTime)
    {

        $startTime = Carbon::parse($startDateTime);
    $endTime = Carbon::parse($endDateTime);

    // Calculate the difference
    $diff = $endTime->diff($startTime);

    // Format the difference including days
    $formattedDiff = sprintf('%d:%02d:%02d', $diff->d * 24 + $diff->h, $diff->i, $diff->s);

    return $formattedDiff;
    }

    public function sendPushNotification($firebaseToken,$title,$body,$deviceType=0,$extraData=[],$badgeCount=0)
    {    
       // $deviceType = 0;
        $SERVER_API_KEY = env('FCM_SERVER_KEY');
        
        if($deviceType == 1){
            $data = [
                "to" => $firebaseToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                    "sound" => "default",  
                   // "badge" => $badgeCount, 
                ],
                "data" => $extraData,
            ];
        }else{
            $data = [
                "to" => $firebaseToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body,  
                    "sound" => "default",  
                    //"badge" => $badgeCount, 
                ],
                "data" => $extraData,
                "priority" => "high"
            ];
        }
        
        $dataString = json_encode($data);
        
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
      
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                 
        $response = curl_exec($ch);
        return true;
    } 

}
