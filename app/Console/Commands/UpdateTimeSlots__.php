<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TimeSlot;
use Carbon\Carbon;

class UpdateTimeSlots extends Command
{
    protected $signature = '';
    protected $description = 'Update time slots based on current time';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $currentTime = now();
        $slots = TimeSlot::all();

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
