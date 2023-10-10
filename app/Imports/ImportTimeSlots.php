<?php

namespace App\Imports;

use App\Models\TimeSlot;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportTimeSlots implements ToModel, WithHeadingRow, WithValidation
{
    public $headingRow = false;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $companyId = trim($row['company_id']);
        $noOfSlots = trim($row['no_of_slots']);
        $date      = trim($row['date']);
        $slot      = trim($row['slot']);

        $existingTimeSlot = TimeSlot::where('company_id', $companyId)
                                        ->where('slot', $slot)
                                        ->whereDate('start_date_time', $date)
                                        ->first();
        if($existingTimeSlot){
            // Update the existing record
            $existingTimeSlot->update([
                'no_of_slots'     => $noOfSlots,
                'remaining_slots' => $noOfSlots,
                'end_date_time'   => $date,
            ]);
            
            return $existingTimeSlot; // Return the updated model
        }

        return new TimeSlot([
            'company_id'      => $companyId,
            'no_of_slots'     => $noOfSlots,
            'remaining_slots' => $noOfSlots,
            'start_date_time' => $date,
            'end_date_time'   => $date,
            'slot'            => $slot
        ]);
    }

    public function rules(): array
    {
        return [
            'company_id' => 'required',
            'company_name' => 'required',
            'date' => 'required',
            'slot' => 'required',
            'no_of_slots' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'company_id.required' => trans('Company id field required in sheet.Please upload again'),
            'company_name.required' => trans('Company Name field required in sheet.Please upload again'),
            'date.required' => trans('Date field required in sheet.Please upload again'),
            'slot.required' => trans('Slot field required in sheet.Please upload again'),
            'no_of_slots.required' => trans('No of slots field required in sheet.Please upload again'),
        ];
    }

}
