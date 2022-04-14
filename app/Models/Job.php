<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\File;
use App\Models\TimelineEvent;
use App\Models\Message;

class Job extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $fillable = [
    'client_id',
    'technician_id',
    'job_type',
    'description',
    'status',
    'deadline',
    'notify_client',
    'notify_technician',
    'client_name',
    'client_surname',
    'technician_name',
    'technician_surname',
    'rating'
  ];
  protected static function booted()
  {
    static::deleted(function ($job) {
      TimelineEvent::destroy(TimelineEvent::where('job_id', $job->id)->pluck("id"));
      Message::destroy(Message::where('job_id', $job->id)->pluck("id"));
      File::destroy(File::where('job_id', $job->id)->pluck("id"));
    });
  }
}
