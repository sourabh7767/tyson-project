<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobFormPlumbing extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'amount_collected',
        'service_titan_number',
        'amount_financed',
        'job_id',
        'user_id',
        'i_sold_it',
        'i_did_it',
        'i_set_the_lead'
    ];
}
