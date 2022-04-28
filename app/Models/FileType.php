<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name'
    ];

    public $timestamps = false;
    protected $table = 'file_types';

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
