<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table ="company";

    public function getAllCompany($request = null,$flag = false)
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
        $query = self::select("company.*")->orderBy($column, $order);

        if(!empty($request)){

            $search = $request['search']['value'];

            if(!empty($search)){
                 $query->where(function ($query) use($request,$search){
                        $query->orWhere( 'name', 'LIKE', '%'. $search .'%');
                            //->orWhere( 'email', 'LIKE', '%'. $search .'%')
                           // ->orWhere( 'roles.title', 'LIKE', '%'. $search .'%')
                            //->orWhere('users.created_at', 'LIKE', '%' . $search . '%');

                    });

                
                       

                 if($flag)
                    return $query->count();
            }

            $start =  $request['start'];
            $length = $request['length'];
            $query->offset($start)->limit($length);


        }

        


        $query = $query->get();

        // print_r($query);
        // die();

        return $query;
    }

    public static function getColumnForSorting($value){

        $list = [
            0=>'id',
            1=>'name',
        ];

        return isset($list[$value])?$list[$value]:"";
    }
}
