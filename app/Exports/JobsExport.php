<?php
namespace App\Exports;

use App\Models\Job;
use Illuminate\Http\Client\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobsExport implements FromQuery, WithHeadings
{
    // public function __construct($request)
    // {
    //     $this->filter = $request->all();
    // }
    public function query()
    {
        return Job::query()
    ->join('users', 'jobs.user_id', '=', 'users.id')
    ->select(
        'users.full_name as full_name',
        'jobs.service_titan_number',
        \DB::raw("DATE(jobs.dispatch_time) as start_date"),
        \DB::raw("TIME(jobs.dispatch_time) as in_time"),
        'jobs.dispatch_address as start_location',

        \DB::raw("DATE(jobs.arrival_time) as arrival_date"),
        \DB::raw("TIME(jobs.arrival_time) as arrival_in"),
        'jobs.arrival_address as arrival_address',

        \DB::raw("DATE(jobs.checkout_time) as end_date"),
        \DB::raw("TIME(jobs.checkout_time) as out_time"),
        'jobs.checkout_address as end_location',
        'jobs.total_hours',
    );

    }

    public function headings(): array
    {
        return [
            // 'ID',
            'Full name',
            'Job',
            'Start Date',
            'In',
            'Start location',
            'Arrival Date',
            'Arrival In',
            'Arrival location',
            'End Date',
            'Out',
            'End location',
            'Shift Hours',
        ];
    }
}
