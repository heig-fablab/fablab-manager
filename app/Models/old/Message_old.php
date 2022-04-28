<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    //use SoftDeletes;
    protected $fillable = [
      'sender_id',
      'recipient_id',
      'job_id',
      'text',
      'notify'
    ];
}
