<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditJob extends Model
{
    use HasFactory;
    public function editJobs()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
