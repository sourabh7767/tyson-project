<?php

namespace App\Imports;

use App\Models\TimeSlot;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportTimeSlots implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TimeSlot([
            //
        ]);
    }
}
