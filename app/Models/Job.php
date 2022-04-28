<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'rating',
        'status'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'new',
    ];

    // From many relationships
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // From foreign keys
    public function user()
    {
        return $this->belongsTo(User::class, 'user_email');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_email');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_email');
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'id_category');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'id_file');
    }
}
