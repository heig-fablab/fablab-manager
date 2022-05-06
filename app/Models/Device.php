<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Device",
 *     description="Device model",
 *     @OA\Xml(
 *         name="Device"
 *     )
 * )
 */
class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        /**
         * @OA\Property(
         *     title="name",
         *     description="Name of the device",
         *     example=3d-printer
         * )
         *
         * @var integer
         */
        'name', 

        /**
         * @OA\Property(
         *     title="image_path",
         *     description="Path of the image of the device",
         *     example=/test/test.jpg
         * )
         *
         * @var integer
         */
        'image_path',

        /**
         * @OA\Property(
         *     title="description",
         *     description="Description of the device",
         *     example=This is a 3D printer
         * )
         *
         * @var integer
         */
        'description'
    ];

    // Options
    public $timestamps = false;

    // Belongs to Many
    public function categories()
    {
        return $this->belongsToMany(JobCategory::class);
    }
}
