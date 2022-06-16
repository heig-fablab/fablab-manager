<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    // API Standard function
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function show($switch_uuid)
    {
        // TODO: verify $switch_uuid input
        $user = User::findOrFail($switch_uuid);
        $user->roles = $user->roles;
        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        // Add client role by default
        $user->roles()->attach(Role::where('name', 'client')->first()->id);

        // Add other roles
        foreach ($request->roles as $role_name) {
            $user->roles()->attach(Role::where('name', $role_name)->first()->id);
        }

        return new UserResource($user);
    }

    public function update(StoreUserRequest $request)
    {
        $req_validated = $request->validated();
        $user = User::findOrFail($request->switch_uuid);

        // Update all roles
        $user->roles()->detach();
        $user->roles()->attach(Role::where('name', 'client')->first()->id);
        foreach ($request->roles as $role_name) {
            $user->roles()->attach(Role::where('name', $role_name)->first()->id);
        }

        $user->update($req_validated);

        return new UserResource($user);
    }

    public function destroy($switch_uuid)
    {
        // TODO: verify $switch_uuid input
        User::findOrFail($switch_uuid)->delete();
        return response()->json([
            'message' => "Device deleted successfully!"
        ], 200);
    }
}
