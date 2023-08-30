<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory; 

    public static function getColumnForSorting($value){

        $list = [
            0=>'id',
            1=>'no_of_slots',
            2=>'remaining_slots'
        ];

        return isset($list[$value])?$list[$value]:"";
    }

    public function getAllSlots($request = null,$flag = false)
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
        $query = self::select("time_slots.*","company.name")->leftJoin('company', 'company.id', '=', 'time_slots.company_id')->orderBy($column, $order);

        if(!empty($request)){

            $search = $request['search']['value'];

            if(!empty($search)){
                 $query->where(function ($query) use($request,$search){
                        $query->orWhere( 'company.name', 'LIKE', '%'. $search .'%');
                            //->orWhere( 'email', 'LIKE', '%'. $search .'%')
                            //->orWhere( 'roles.title', 'LIKE', '%'. $search .'%')
                            //->orWhere('users.created_at', 'LIKE', '%' . $search . '%');

                    });

                //  if(empty(strcasecmp("Inactive",$search))){
                //     $query->orWhere( 'status',  0);

                //  }
                // if(empty(strcasecmp("Active",$search))){
                //     $query->orWhere( 'status',  1);

                //  }

                  // if(is_int(stripos("Inactive", $search))){
                  //           $query->orWhere( 'status',  0);

                  //       }
                 // if(is_int(stripos("Active", $search))){
                 //            $query->orWhere( 'status',  1);

                 //        }
                       

                 if($flag)
                    return $query->count();
            }

            $start =  $request['start'];
            $length = $request['length'];
            $query->offset($start)->limit($length);


        }

        


        $query = $query->get();

        //  print_r($query);
        //  die();

        return $query;
    }
}
