<?php
namespace App\Exports;

use App\Models\Job;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobsExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return Job::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'First name',
            'Job',
            'Start Date',
            'In',
            'Start location',
            'End Date',
            'Out',
            'End location',
        ];
    }
}
