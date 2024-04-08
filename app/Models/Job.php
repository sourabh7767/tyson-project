<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'service_titan_number',
        'dispatch_time',
        'user_id',
        "dispatch_address",
        "dispatch_lat",
        "dispatch_long"
    ];

    public static function getColumnForSorting($value){

        $list = [
            0=>'id',
            1=>'customer_name',
            2=>'service_titan_number',
        ];

        return isset($list[$value])?$list[$value]:"";
    }

    public function getAllJobs($request = null, $flag = false)
    {
    	$columnNumber = $request['order'][0]['column'];
        $order = $request['order'][0]['dir'];

        $column = self::getColumnForSorting($columnNumber);

        if($columnNumber == 0){
            $order = "desc";
        }

        if(empty($column)){
            $column = 'id';
        }
        $query = self::select("jobs.id","jobs.customer_name","jobs.service_titan_number","jobs.dispatch_time","jobs.dispatch_address","jobs.checkout_address","jobs.checkout_time","job_forms.total_amount","job_forms.status")->leftJoin('job_forms', 'job_forms.job_id', '=', 'jobs.id')->orderBy($column, $order);

        if(!empty($request)){

            $search = $request['search']['value'];

            if(!empty($search)){
                 $query->where(function ($query) use($request,$search){
                        $query->orWhere( 'jobs.customer_name', 'LIKE', '%'. $search .'%')
                            ->orWhere( 'jobs.service_titan_number', 'LIKE', '%'. $search .'%');

                    });

                 if($flag)
                    return $query->count();
            }
            if($request->has('selected_id') && !empty($request->selected_id)){
                $query->where("jobs.user_id",$request->selected_id);
                // if($flag)
                //     return $query->count();
            }
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
                // Apply date range filter to your query
                $query->whereBetween('jobs.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                //->where("jobs.user_id",$request->selected_id);
                // if($flag)
                //     return $query->count();
            }


            if($request->has("status") && !empty($request->status)){
                $query->where("job_forms.status",$request->status);
            }
            if($flag)
                    return $query->count();

            $start =  $request['start'];
            $length = $request['length'];
            $query->offset($start)->limit($length);
        }

        $query = $query->with('jobForm')->get();

        return $query;
    }
    public function jobForm()
    {
        return $this->hasMany(JobForm::class);
    }
}
