<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type-name'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'file-types';
}
