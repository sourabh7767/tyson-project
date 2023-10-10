<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;
use Validator;
use Illuminate\Support\Facades\Redirect;
use App\Exports\ExportTimeSlots;
use App\Imports\ImportTimeSlots;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{

	public function exportIndex(){
		return view('sheets.index');
	}

	public function export(Request $request){
		$date = $request->date;
		$fileName = "time_slot_".$date.".xlsx";
		return Excel::download(new ExportTimeSlots($date), $fileName);
	}

	public function import(Request $request){
		$request->validate([
	        'file' => 'required|file|mimes:xlsx,xls',
	    ]);

		$file = $request->file('file');
		try {
			Excel::import(new ImportTimeSlots, $file);
		}catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
			$failures = $e->failures();
			// dd($failures);
			$errors = [];
			foreach ($failures as $failure) {
				 $failure->row(); // row that went wrong
				$failure->attribute(); // either heading key (if using heading row concern) or column index
				$errors = $failure->errors(); // Actual error messages from Laravel validator
				$failure->values(); // The values of the row that has failed.
			}
			//die;
			if(!empty($errors)){
				return redirect()->back()->with('error', $errors[0]);
			}
			
			// ->withErrors(['Something went wrong']);
			// return response()->json($failure->errors(), 404);
			// return response()->json(['success'=>'errorList','message'=> $failure->errors()]);
		}
		

		return redirect()->back()->with('success', 'Data imported successfully.');
	}

}