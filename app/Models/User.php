<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'email', 
        'name', 
        'surname',
        'password'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'email';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the validator user.
     */
    public function validator()
    {
        return $this->belongsTo('App\Validator', 'foreign_key', 'other_key');
    }
}
