<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobCategory extends Model
{
    use HasFactory;

    protected $table = 'job_categories';

    protected $fillable = [
        'acronym',
        'name',
        'description'
    ];

    // Options
    public $timestamps = false;

    // Has one
    public function file(): HasOne
    {
        return $this->hasOne(File::class);
    }

    // Has many
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function file_types(): BelongsToMany
    {
        return $this->belongsToMany(FileType::class);
    }
}
