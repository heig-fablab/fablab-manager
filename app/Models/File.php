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
        'hash_name'
    ];

    public function file_type()
    {
        return $this->belongsTo(FileType::class, 'id_file_type');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'id_job');
    }
}
