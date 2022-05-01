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

    public $timestamps = false;

    public function categories()
    {
        return $this->belongsToMany(Device::class, 'job_category_has_device', 'id_device', 'id_category');
    }
}
