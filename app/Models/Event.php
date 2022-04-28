<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'data'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'id_job');
    }
}
