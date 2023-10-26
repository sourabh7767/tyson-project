<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;
use App\Models\Booking;
use App\Models\Company;
use Validator;
use Illuminate\Support\Facades\Redirect;

class TimeSlotController extends Controller
{
    public function index(request $request,TimeSlot $timeSlots){
        if ($request->ajax()) {

            $slots = $timeSlots->getAllSlots($request);

            $totalSlots = TimeSlot::whereDate('start_date_time', '>=', date('Y-m-d'))->count();

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
                $btn ='<button class="edit-button" data-id="' . $user->id . '">Edit Here</button>&nbsp;&nbsp;';
                // $btn = '<a href="' . route('users.show',encrypt($user->id)) . '" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
                 $btn .= '<a href="' . route('time_slot.edit',encrypt($user->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';
                 $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' .$user->id. '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';

                return $btn;
            })
                ->rawColumns([
                'action',
                //'status'
            ])->setTotalRecords($totalSlots)->setFilteredRecords($setFilteredRecords)->skipPaging()
                ->make(true);
        }
        $dateStrings = $dates = $slotsDataArr = $week = $allSlots = $company_id = "";
        $company = Company::pluck("name","id")->toArray();
        $allSlots = ["8AM - 9AM","10AM - 1PM","12PM - 3PM","2PM - 5PM"];
        if($company){
            if($request->has("company_id")){
                $company_id = $request->company_id;
            }else{
                $company_id = array_key_first($company);
            }
            
            $week = "current";
            $today = now();
            $dateStrings = [];
            $slotsDataArr = $dates = [];

            for ($i = 0; $i <= 6; $i++) {
                if ($i == 0) {
                    $dates[] = $dateToCheck = $today->format('Y-m-d');
                    $dateStrings[$dateToCheck] = 'Today';
                    $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$company_id)
                                        ->whereDate("start_date_time",$today)
                                            ->get();
                    $slotsData = TimeSlot::where("company_id",$company_id)
                                            ->whereDate("start_date_time",date("Y-m-d"))
                                            ->get();                                                
                } elseif ($i == 1) {
                    $dates[] = $dateToCheck = $today->addDay()->format('Y-m-d');
                    $dateStrings[$dateToCheck] = 'Tomorrow';
                    $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$company_id)
                                        ->whereDate("start_date_time",$dateToCheck)
                                            ->get();
                } else {
                    $dates[] = $dateToCheck = $today->addDay()->format('Y-m-d');
                    $dateStrings[$dateToCheck] = '+' . $i . ' days';
                    $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$company_id)
                                        ->whereDate("start_date_time",$dateToCheck)
                                            ->get();
                }
            }
        }
        return view('time_slot.index',compact('company',"dateStrings","dates","slotsDataArr","week","allSlots","company_id"));
    }

    public function archieveTimeSlots(request $request,TimeSlot $timeSlots){
        if ($request->ajax()) {

            $slots = $timeSlots->getArchievSlots($request);

            $totalSlots = TimeSlot::whereDate('start_date_time', '<', date("Y-m-d"))->count();

             $search = $request['search']['value'];

             $setFilteredRecords = $totalSlots;

            if(!empty($search)){

            $setFilteredRecords = $timeSlots->getArchievSlots($request,true);

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
                 $btn .= '<a href="' . route('time_slot.edit',encrypt($user->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';
                 $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' .$user->id. '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';

                return $btn;
            })
                ->rawColumns([
                'action',
                //'status'
            ])->setTotalRecords($totalSlots)->setFilteredRecords($setFilteredRecords)->skipPaging()
                ->make(true);
        }
        $dateStrings = $dates = $slotsDataArr = $week = $allSlots = $company_id = "";
        $company = Company::pluck("name","id")->toArray();
        $allSlots = ["8AM - 9AM","10AM - 1PM","12PM - 3PM","2PM - 5PM"];
        if($company){
            if($request->has("company_id")){
                $company_id = $request->company_id;
            }else{
                $company_id = array_key_first($company);
            }
            
            $week = "current";
            $today = now();
            $dateStrings = [];
            $slotsDataArr = $dates = [];

            for ($i = 0; $i <= 6; $i++) {
                if ($i == 0) {
                    $dates[] = $dateToCheck = $today->format('Y-m-d');
                    $dateStrings[$dateToCheck] = 'Today';
                    $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$company_id)
                                        ->whereDate("start_date_time",$today)
                                            ->get();
                    $slotsData = TimeSlot::where("company_id",$company_id)
                                            ->whereDate("start_date_time",date("Y-m-d"))
                                            ->get();                                                
                } elseif ($i == 1) {
                    $dates[] = $dateToCheck = $today->addDay()->format('Y-m-d');
                    $dateStrings[$dateToCheck] = 'Tomorrow';
                    $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$company_id)
                                        ->whereDate("start_date_time",$dateToCheck)
                                            ->get();
                } else {
                    $dates[] = $dateToCheck = $today->addDay()->format('Y-m-d');
                    $dateStrings[$dateToCheck] = '+' . $i . ' days';
                    $slotsDataArr[$dateToCheck] = TimeSlot::where("company_id",$company_id)
                                        ->whereDate("start_date_time",$dateToCheck)
                                            ->get();
                }
            }
        }
        return view('time_slot.archieve',compact('company',"dateStrings","dates","slotsDataArr","week","allSlots","company_id"));
    }

    public function deleteTimeSlot($id,request $request){

        $slot = TimeSlot::find($id);

        if(!$slot){
            return returnNotFoundResponse('This time slot does not exist');
        }

        Booking::where("slot_id",$id)->delete();
        TimeSlot::where("id",$id)->delete();

        return returnSuccessResponse('Time Slot deleted successfully');
    }

    public function edit($id){
        $company = Company::pluck("name","id")->toArray();
        $timeSlot = TimeSlot::where("id",decrypt($id))->first();
        return view('time_slot.edit',compact('company','timeSlot'));
    }

    public function update(request $request){
        
        $rules = array(
           'company_id' => 'required',
           'date' => 'required',
           'slot' => 'required',
           'no_of_slots' => 'required',
           'id' =>  'required'              
       );

       $message = ['company_id.required'=>'Company is required'];
       $validator = Validator::make($request->all(), $rules,$message);
       if ($validator->fails()) {
           // echo "<pre>";print_r( $validator->messages());die;
           return Redirect::back()->withInput()->withErrors($validator);
       }

        $obj = TimeSlot::where("id",$request->id)->first();
        if($obj){
            //$obj->company_id = $request->company_id;
            //$obj->start_date_time = $request->date;
            //$obj->end_date_time = $request->date;
            //$obj->slot = $request->slot[0];
            $obj->no_of_slots = $request->no_of_slots[0];
            $obj->remaining_slots = $request->no_of_slots[0];
            $obj->save();
    
        }else{
            return redirect()->back()->with('error', 'Unable to create slot. Please try again later.');
        }
        
        return redirect()->route('time_slot.index')->with('success', 'Time Slot created successfully.');
    }

    public function create(request $request){
        $company = Company::pluck("name","id")->toArray();
        return view('time_slot.create',compact('company'));
    }

    public function store(request $request){
      //  echo "<pre>";print_r($request->all());die;
        $rules = array(
            'company_id' => 'required',
           'date' => 'required',
           'slot' => 'required',
           'no_of_slots' => 'required',               
       );

       $message = ['company_id.required'=>'Company is required'];
       $validator = Validator::make($request->all(), $rules,$message);
       if ($validator->fails()) {
        // $errors = $validator->errors();
        // echo "<pre>";print_r($errors);die;            
           return Redirect::back()->withInput()->withErrors($validator);
       }
        foreach($request->slot as $key => $value){
            if(array_key_exists($key,$request->no_of_slots) && $request->no_of_slots[$key] != ""){
                $res = TimeSlot::where("company_id",$request->company_id)
                            ->whereDate("start_date_time",$request->date)
                            ->where("slot",$value)->first();
                if($res){
                    $validator->getMessageBag()->add("slot", "$value Slot already exits");
                    //  $errors = $validator->errors();
                    //  echo "<pre>";print_r($errors);die;            
                    return Redirect::back()->withInput()->withErrors($validator);
                }
            }
        }
       foreach($request->slot as $key => $value){
            if(array_key_exists($key,$request->no_of_slots) && $request->no_of_slots[$key] != ""){
                $obj = new TimeSlot();
                $obj->company_id = $request->company_id;
                $obj->start_date_time = $request->date;
                $obj->end_date_time = $request->date;
                $obj->slot = $value;
                $obj->no_of_slots = $request->no_of_slots[$key];
                $obj->remaining_slots = $request->no_of_slots[$key];
                $obj->save();
            }
       }
       

    //    if(!$obj->save()){
    //         return redirect()->back()->with('error', 'Unable to create slot. Please try again later.');
    //     }

        return redirect()->route('time_slot.index')->with('success', 'Time Slot created successfully.');
    }

    public function show($id)
    {
        $model = TimeSlot::find(decrypt($id));
        return view('time_slot.view',compact("model"));
    }

    public function updateSlot(request $request){
        $id = $request->id;
        $slot = TimeSlot::find($id);

        if(!$slot){
            return returnNotFoundResponse('This time slot does not exist');
        }

        
        TimeSlot::where("id",$id)->update(["no_of_slots"=>$request->no_of_slots,"remaining_slots" => $request->no_of_slots]);

        return returnSuccessResponse('Time Slot updated successfully');        
    }
}
