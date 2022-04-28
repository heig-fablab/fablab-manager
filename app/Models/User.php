<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

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
     * Get the validator user.
     */
    public function validator()
    {
        return $this->belongsTo('App\Validator', 'foreign_key', 'other_key');
    }
}
