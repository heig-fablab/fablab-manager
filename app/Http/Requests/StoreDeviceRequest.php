<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Store Device request",
 *      description="Store Device request body data",
 *      type="object",
 *      required={"name"}
 *      required={"image_path"}
 *      required={"description"}
 * )
 */
class StoreDeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Will be managed in a policy
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            /**
             * @OA\Property(
             *     title="name",
             *     description="Name of the device",
             *     example=3d-printer
             * )
             *
             * @var integer
             */
            'name' => ['required'],

            /**
             * @OA\Property(
             *     title="image_path",
             *     description="Path of the image of the device",
             *     example=/test/test.jpg
             * )
             *
             * @var integer
             */
            'image_path'  => ['required'],

            /**
             * @OA\Property(
             *     title="description",
             *     description="Description of the device",
             *     example=This is a 3D printer
             * )
             *
             * @var integer
             */
            'description' => ['required'],
        ];
    }
}
