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

    public $timestamps = false;
    protected $primaryKey = 'email';

    public function user_jobs()
    {
        return $this->hasMany(Job::class, 'user_email');
    }

    public function technician_jobs()
    {
        return $this->hasMany(Job::class, 'technician_email');
    }

    public function validator_jobs()
    {
        return $this->hasMany(Job::class, 'validator_email');
    }

    public function sended_messages()
    {
        return $this->hasMany(Message::class, 'sender_email');
    }

    public function received_messages()
    {
        return $this->hasMany(Message::class, 'receiver_email');
    }

    // Many to many
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_has_role', 'id_user', 'id_role');
    }
}
