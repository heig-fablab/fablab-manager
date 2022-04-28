<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validator extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user-email'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user record associated.
     */
    public function user()
    {
        return $this->hasOne('App\User', 'foreign_key', 'local_key');
    }
}
