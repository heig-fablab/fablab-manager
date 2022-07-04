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
        'name',
        'description'
    ];

    // Options
    public $timestamps = false;

    // Has one
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    // Has many
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function file_types()
    {
        return $this->belongsToMany(FileType::class);
    }
}
