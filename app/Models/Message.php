<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'text',
        'job_id',
        'sender_username',
        'receiver_username'
    ];

    // Belongs to
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_username');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_username');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
