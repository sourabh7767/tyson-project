<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = "booking";

    public function companyData(){
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function slotData(){
        return $this->hasOne(TimeSlot::class, 'id', 'slot_id');
    }
}
