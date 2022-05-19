<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreDeviceRequest;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use Illuminate\Http\Request;

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
        return new DeviceResource(Device::find($id));
    }

    public function store(StoreDeviceRequest $request)
    {
        $device = Device::create($request->validated());
        return new DeviceResource($device);
    }

    public function update(StoreDeviceRequest $request)
    {
        $device = Device::find($request->id);
        $device->update($request->validated());
        return new DeviceResource($device);
    }

    public function destroy($id)
    {
        Device::find($id)->delete();
        return response()->json([
            'message' => "Device deleted successfully!"
        ], 200);
    }
}
