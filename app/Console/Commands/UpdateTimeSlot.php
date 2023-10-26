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
        $currentTime = now();
        $slots = TimeSlot::whereDate('start_date_time', $currentTime)->get();

        foreach ($slots as $slot) {
            
            $slotTimes = explode(' - ', $slot->slot);
            $startTime = Carbon::createFromFormat('hA', $slotTimes[1]);
            $comparisonTime = $currentTime->subMinutes(30);
            
            if ($startTime->lessThanOrEqualTo($currentTime) && $startTime->greaterThan($comparisonTime)) {
                $slot->update([
                    'no_of_slots' => 0,
                    'remaining_slots' => 0
                ]);
            }
        }

        $this->info('Time slots updated successfully.');
    }
}
