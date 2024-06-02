<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_amount',
        'service_titan_number',
        'comission',
        'job_id',
        'user_id',
        'job_form_type',
        'comission_amount',
        "is_lead"
    ];
}
