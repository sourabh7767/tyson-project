<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;
use Validator;
use Illuminate\Support\Facades\Redirect;

class TimeSlotController extends Controller
{
    public function index(request $request,TimeSlot $timeSlots){
        if ($request->ajax()) {

            $slots = $timeSlots->getAllSlots($request);

            $totalSlots = TimeSlot::count();

             $search = $request['search']['value'];

             $setFilteredRecords = $totalSlots;

            if(!empty($search)){

            $setFilteredRecords = $timeSlots->getAllSlots($request,true);

           }

            return datatables()->of($slots)
                ->addIndexColumn()
                // ->addColumn('status', function ($user) {
                //       return  '<span class="badge badge-light-'.$user->getStatusBadge().'">'.$user->getStatus().'</span>';
                // })
                // ->addColumn('company_name', function ($slots) {
                //     echo "<pre>";print_r($slots);die;
                // })
                ->addColumn('start_date_time', function ($slots) {
                    return date("Y-m-d",strtotime($slots->start_date_time));
                })

                ->addColumn('action', function ($user) {
                $btn = '';
                // $btn = '<a href="' . route('users.show',encrypt($user->id)) . '" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
                // $btn .= '<a href="' . route('users.edit',encrypt($user->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';
                // $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' .$user->id. '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';

                return $btn;
            })
                ->rawColumns([
                'action',
                //'status'
            ])->setTotalRecords($totalSlots)->setFilteredRecords($setFilteredRecords)->skipPaging()
                ->make(true);
        }

        return view('time_slot.index');
    }

    public function create(request $request){
        return view('time_slot.create');
    }

    public function store(request $request){
        $rules = array(
            'company_id' => 'required',
           'date' => 'required',
           'slot' => 'required',
           'no_of_slots' => 'required',               
       );

       $message = ['company_id.required'=>'Company is required'];
       $validator = Validator::make($request->all(), $rules,$message);
       if ($validator->fails()) {
           return Redirect::back()->withInput()->withErrors($validator);
       }

       $obj = new TimeSlot();
       $obj->company_id = $request->company_id;
       $obj->start_date_time = $request->date;
       $obj->end_date_time = $request->date;
       $obj->slot = $request->slot;
       $obj->no_of_slots = $request->no_of_slots;
       $obj->remaining_slots = $request->no_of_slots;

       if(!$obj->save()){
            return redirect()->back()->with('error', 'Unable to create slot. Please try again later.');
        }

        return redirect()->route('time_slot.index')->with('success', 'Time Slot created successfully.');
    }

    public function show($id)
    {
        $model = TimeSlot::find(decrypt($id));
        return view('time_slot.view',compact("model"));
    }
}
