<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mime_type'
    ];

    // Options
    public $timestamps = false;

    // Has many
    public function files()
    {
        return $this->hasMany(File::class);
    }

    // Belongs to many
    public function categories()
    {
        return $this->belongsToMany(JobCategory::class);
    }
}
