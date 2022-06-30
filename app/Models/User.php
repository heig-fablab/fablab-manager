<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    //use Authenticatable;
    use HasFactory;
    use SoftDeletes;

    // Primary key options
    protected $primaryKey = 'username';
    protected $keyType = 'string';

    protected $fillable = [
        'username',
        'email',
        'name',
        'surname',
        'password',
        'require_status_email',
        'require_files_email',
        'require_messages_email',
        'last_email_sent'
    ];

    // Default values
    protected $attributes = [
        'require_status_email' => true,
        'require_files_email' => true,
        'require_messages_email' => true
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'last_email_sent'
    ];

    // Options
    public $timestamps = false;
    public $incrementing = false;

    // Has many
    public function requestor_jobs()
    {
        return $this->hasMany(Job::class, 'client_username');
    }

    public function worker_jobs()
    {
        return $this->hasMany(Job::class, 'worker_username');
    }

    public function validator_jobs()
    {
        return $this->hasMany(Job::class, 'validator_username');
    }

    public function sended_messages()
    {
        return $this->hasMany(Message::class, 'sender_username');
    }

    public function received_messages()
    {
        return $this->hasMany(Message::class, 'receiver_username');
    }

    // Belongs to many
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // User Service
    public function has_given_role(string $role)
    {
        return $this->roles->pluck('name')->contains($role);
    }
}
