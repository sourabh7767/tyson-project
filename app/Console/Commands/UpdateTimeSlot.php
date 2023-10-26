<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TimeSlot;
use Carbon\Carbon;

class UpdateTimeSlot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time-slots:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update time slots based on current time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $currentTime = now()->setTimezone('Asia/Kolkata');
        
        $slots = TimeSlot::whereDate('start_date_time', $currentTime->toDateString())->get();
        $todayDate = $currentTime->toDateString();
        foreach ($slots as $slot) {
            // echo "<pre>";print_r($slot);die;    
            $slotTimes = explode(' - ', $slot->slot);
            //echo $todayDate." ".$slotTimes[0];die;
            //$startTime = Carbon::createFromFormat('Y-m-d hA', $todayDate." ".$slotTimes[0]);
            $startTime = Carbon::parse($slotTimes[0], "Asia/Kolkata");
            //echo "<pre>";print_r($startTime);die;

           
            $comparisonTime = $startTime->subMinutes(30);
               
            if ($startTime->lessThanOrEqualTo($currentTime) || $currentTime->greaterThan($comparisonTime)) {
                $slot->update([
                    'no_of_slots' => 0,
                    'remaining_slots' => 0
                ]);
            }
        }

        $this->info('Time slots updated successfully.');
    }
}
