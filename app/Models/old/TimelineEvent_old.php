<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimelineEvent extends Model
{
    use HasFactory;
    //use SoftDeletes;
    protected $fillable = [
      'job_id',
      'type',
      'data',
      'notify_client',
      'notify_technician'
  ];
}
