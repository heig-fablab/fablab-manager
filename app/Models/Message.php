<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'id_job'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_email');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_email');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'id_job');
    }
}
