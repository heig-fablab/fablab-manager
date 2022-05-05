<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $table = 'job_categories';

    protected $fillable = [
        'acronym',
        'name'
    ];

    // Options
    public $timestamps = false;

    // Has many
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    // Belongs to many
    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }

    public function file_types()
    {
        return $this->belongsToMany(FileType::class);
    }
}
