<?php

namespace App\Http\Controllers\MobileApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobForm;

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
                'status'
            ])->setTotalRecords($totalJobs)->setFilteredRecords($setFilteredRecords)->skipPaging()
                ->make(true);
        }

        return view('jobs.index');
    }

    public function show($jobId)
    {
        $model = Job::with('jobForm')->where('id', decrypt($jobId) )->first();
        //echo"<pre>";print_r($model->jobForm);die;
        return view('jobs.view',compact("model"));
    }

    public function updateJobStatus(request $request){
        $id = $request->id;
        $job = Job::find($id);

        if(!$job){
            return returnNotFoundResponse('This Job does not exist');
        }

        
        JobForm::where("job_id",$request->id)->update(["status"=>$request->job_status]);

        return returnSuccessResponse('Status updated successfully');
    }
}
