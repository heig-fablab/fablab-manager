<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'image_path', 
        'description'
    ];

    // Options
    public $timestamps = false;

    // Belongs to Many
    public function categories()
    {
        return $this->belongsToMany(JobCategory::class);
    }
}
