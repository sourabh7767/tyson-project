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
        'user_id'
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
        $query = self::select("jobs.id","jobs.customer_name","jobs.service_titan_number","jobs.dispatch_time","jobs.checkout_time","job_forms.total_amount","job_forms.status")->leftJoin('job_forms', 'job_forms.job_id', '=', 'jobs.id')->orderBy($column, $order);

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

            if($request->has("status") && !empty($request->status)){
                $query->where("job_forms.status",$request->status);
            }

            $start =  $request['start'];
            $length = $request['length'];
            $query->offset($start)->limit($length);
        }

        $query = $query->get();

        return $query;
    }

    public function jobForm()
    {
        return $this->hasMany(JobForm::class);
    }
}
