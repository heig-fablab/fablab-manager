<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
    protected $table = 'file_types';

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function categories()
    {
        return $this->belongsToMany(FileType::class, 'job_category_has_file_type', 'id_file_type', 'id_category');
    }
}
