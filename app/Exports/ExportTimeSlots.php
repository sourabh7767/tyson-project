<?php

namespace App\Exports;

use App\Models\TimeSlot;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportTimeSlots implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TimeSlot::all();
    }
}
