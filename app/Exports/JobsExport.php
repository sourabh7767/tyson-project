<?php
namespace App\Exports;

use App\Models\Job;
use Illuminate\Http\Client\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class JobsExport implements FromCollection, WithHeadings, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $selectedUsers;

    public function __construct($startDate, $endDate, $selectedUsers)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->selectedUsers = $selectedUsers;
    }
    public function collection()
    {
        $query = Job::query()
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
        // Apply filters if they are provided
        if (!empty($this->startDate) && !empty($this->endDate)) {

            // $startDate = $startDate;
            // $endDate = $this->filter['endDate'];
            $query->whereBetween('jobs.created_at', [$this->startDate, $this->endDate]);
        }
        if(!empty($this->selectedUsers)){
            $query->where("jobs.user_id",$this->selectedUsers);
        }
        return  $query->get();

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
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getHighestRow();
                
                $totalSeconds = 0;
                foreach ($this->collection() as $job) {
                    $timeParts = explode(':', $job->total_hours);
                    if (count($timeParts) == 3) {
                        $hours = intval($timeParts[0]);
                        $minutes = intval($timeParts[1]);
                        $seconds = intval($timeParts[2]);
                        $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;
                    } else {
                        // Log or handle invalid time values
                    }
                }
    
                // Calculate hours, minutes, and seconds from total seconds
                $hours = floor($totalSeconds / 3600);
                $totalSeconds %= 3600;
                $minutes = floor($totalSeconds / 60);
                $seconds = $totalSeconds % 60;
    
                // Format the total hours string
                $totalHours = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    
                // Append the sum of total hours to the Excel sheet
                $event->sheet->setCellValue('L' . ($highestRow + 1), $totalHours);
                
                // Optionally, you can apply formatting to the total hours cell
                $event->sheet->getStyle('L' . ($highestRow + 1))->getFont()->setBold(true);
            },
        ];
    }
}
