<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
      'job_id',
      'hashed_name',
      'name'
  ];
  protected static function booted()
  {
    static::deleting(function ($file) {
      if(File::where('hashed_name', $file->hashed_name)->count() == 1)
      {
        Storage::delete("FileStorage/$file->hashed_name");
      }
    });
  }
}
