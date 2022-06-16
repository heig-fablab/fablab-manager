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
        'sender_switch_uuid',
        'receiver_switch_uuid'
    ];

    // Belongs to
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_switch_uuid');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_switch_uuid');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
