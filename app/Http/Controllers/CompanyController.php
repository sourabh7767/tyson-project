<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Booking;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Redirect;
use Validator;


class CompanyController extends Controller
{
    public function index(request $request,Company $company){
        if ($request->ajax()) {

            $companyData = $company->getAllCompany($request);

            $totalCompany = Company::count();

             $search = $request['search']['value'];

             $setFilteredRecords = $totalCompany;

            if(!empty($search)){

            $setFilteredRecords = $companyData->getAllCompany($request,true);

           }

            return datatables()->of($companyData)
                ->addIndexColumn()
                // ->addColumn('status', function ($user) {
                //       return  '<span class="badge badge-light-'.$user->getStatusBadge().'">'.$user->getStatus().'</span>';
                // })
              
                // ->addColumn('created_at', function ($user) {
                //     return $user->created_at;
                // })

                ->addColumn('action', function ($user) {
                $btn = '';
                //$btn = '<a href="' . route('users.show',encrypt($user->id)) . '" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
               // $btn .= '<a href="' . route('users.edit',encrypt($user->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';
                $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' .$user->id. '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';

                return $btn;
            })
                ->rawColumns([
                'action',
                'status'
            ])->setTotalRecords($totalCompany)->setFilteredRecords($setFilteredRecords)->skipPaging()
                ->make(true);
        }

        return view('company.index');
    }

    public function deleteCompany($id){
        $slot = Company::find($id);

        if(!$slot){
            return returnNotFoundResponse('This company does not exist');
        }

        Booking::where("company_id",$id)->delete();
        TimeSlot::where("company_id",$id)->delete();
        Company::where("id",$id)->delete();

        return returnSuccessResponse('Company deleted successfully');
    }

    public function add(request $request){
        return view('company.create');
    }

    public function store(request $request){
        $rules = array(
            'name' => 'required',
       );

       $message = [];
       $validator = Validator::make($request->all(), $rules,$message);
       if ($validator->fails()) {
          // dd($validator);
           return Redirect::back()->withInput()->withErrors($validator);
       }  

       $obj = new Company();
       $obj->name = $request->name;

       if(!$obj->save()){
            return redirect()->back()->with('error', 'Unable to create Company. Please try again later.');
        }

        return redirect()->route('company.index')->with('success', 'Company created successfully.');
    }
}
