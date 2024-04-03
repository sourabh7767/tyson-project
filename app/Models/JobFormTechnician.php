<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobFormTechnician extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_total',
        'service_titan_number',
        'total_pay',
        'job_id',
        'user_id',
        'i_sold_it',
        'vip_sold'
    ];
}
