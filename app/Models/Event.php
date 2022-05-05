<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'job_id'
    ];

    // Belongs to
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
