<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 
        'hash',
        'directory',
        'file_type_id',
        'job_id'
    ];

    // Belongs to
    public function file_type()
    {
        return $this->belongsTo(FileType::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
