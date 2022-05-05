<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'acronym',
        'name'
    ];

    public $timestamps = false;
    protected $table = 'job_categories';

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    // Many to many
    public function devices()
    {
        return $this->belongsToMany(Device::class, 'job_category_has_device', 'id_category', 'id_device');
    }

    public function file_types()
    {
        return $this->belongsToMany(FileType::class, 'job_category_has_file_type', 'id_category', 'id_file_type');
    }
}
