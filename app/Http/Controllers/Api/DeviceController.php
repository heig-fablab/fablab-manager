<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreDeviceRequest;
use App\Http\Requests\UpdateRequests\UpdateDeviceRequest;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use App\Models\JobCategory;

class DeviceController extends Controller
{
    // API Standard function
    public function index() //Request $request)
    {
        // Authorization
        //$this->authorize('viewAny');

        $devices = Device::all();
        return DeviceResource::collection($devices);
    }

    public function show(int $id)
    {
        return new DeviceResource(Device::findOrFail($id));
    }

    public function store(StoreDeviceRequest $request)
    {
        $device = Device::create($request->validated());

        foreach ($request->job_categories as $job_category_acronym) {
            $device->categories()->attach(JobCategory::where('acronym', $job_category_acronym)->first()->id);
        }

        return new DeviceResource($device);
    }

    public function update(UpdateDeviceRequest $request)
    {
        $req_validated = $request->validated();
        $device = Device::findOrFail($request->id);

        $device->categories()->detach();
        foreach ($request->job_categories as $job_category_acronym) {
            $device->categories()->attach(JobCategory::where('acronym', $job_category_acronym)->first()->id);
        }

        $device->update($req_validated);
        return new DeviceResource($device);
    }

    public function destroy(int $id)
    {
        Device::find($id)->delete();
        return response()->json([
            'message' => "Device deleted successfully!"
        ], 200);
    }
}
