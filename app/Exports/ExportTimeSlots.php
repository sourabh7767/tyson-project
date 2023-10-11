<?php

namespace App\Exports;

use App\Models\TimeSlot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Company;

class ExportTimeSlots implements FromCollection, WithHeadings
{
	private $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$companies = Company::all();
    	$slots = ["8AM - 9AM", "10AM - 1PM", "12PM - 3PM", "2PM - 5PM"];
    	$timeSlotdata = $companies->map(function ($company) use($slots) {
    		$count = 0;
    		foreach($slots as $slot){
    			$count++;
	    		$data[$count]['company_id'] = $company->id;
	    		$data[$count]['company_name'] = $company->name;
	    		$data[$count]['date'] = $this->date;
	    		$data[$count]['slot'] = $slot;
	    		$data[$count]['no_of_slots'] = '0';
			}
			return $data;
    	});
        return $timeSlotdata;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Define the column headings for your Excel sheet
        return [
            'Company ID',
            'Company Name',
            'Date',
            'Slot',
            'No. Of Slots'
        ];
    }
}
