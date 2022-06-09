<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreDeviceRequest;
use App\Http\Requests\UpdateRequests\UpdateDeviceRequest;
use App\Http\Resources\DeviceResource;
use App\Models\Device;

class DeviceController extends Controller
{
    // API Standard function
    public function index()
    {
        $devices = Device::all();
        return DeviceResource::collection($devices);
    }

    public function show($id)
    {
        // TODO: validate $id input
        return new DeviceResource(Device::findOrFail($id));
    }

    public function store(StoreDeviceRequest $request)
    {
        $device = Device::create($request->validated());
        $device->categories()->attach($request->job_categories);
        return new DeviceResource($device);
    }

    public function update(UpdateDeviceRequest $request)
    {
        $req_validated = $request->validated();
        $device = Device::findOrFail($request->id);
        $device->categories()->detach();
        $device->categories()->attach($request->job_categories);
        $device->update($req_validated);
        return new DeviceResource($device);
    }

    public function destroy($id)
    {
        // TODO: validate $id input
        Device::find($id)->delete();
        return response()->json([
            'message' => "Device deleted successfully!"
        ], 200);
    }
}
