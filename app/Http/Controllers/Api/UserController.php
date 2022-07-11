<?php

namespace App\Http\Controllers\Api;

use App\Constants\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserEmailNotificationsRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // API Standard function
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function show($username)
    {
        $user = User::findOrFail($username);
        return new UserResource($user);
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());

        // Add client role by default
        $user->roles()->attach(Role::where('name', Roles::CLIENT)->first()->id);

        // Add other roles
        foreach ($request->roles as $role_name) {
            $user->roles()->attach(Role::where('name', $role_name)->first()->id);
        }

        return new UserResource($user);
    }

    public function update(UserRequest $request)
    {
        $req_validated = $request->validated();
        $user = User::findOrFail($request->username);

        $user_email_exists = User::where('email', $request->email)->first();

        if ($user_email_exists != null && $user_email_exists != $user) {
            return response()->json([
                'message' => "New email is already used by an other user!"
            ], 400);
        }

        // Update all roles
        $user->roles()->detach();
        $user->roles()->attach(Role::where('name', Roles::CLIENT)->first()->id);
        foreach ($request->roles as $role_name) {
            $user->roles()->attach(Role::where('name', $role_name)->first()->id);
        }

        $user->update($req_validated);

        return new UserResource($user);
    }

    public function destroy($username)
    {
        User::findOrFail($username)->delete();
        return response()->json([
            'message' => "Device deleted successfully!"
        ], 200);
    }

    // Others functions
    public function update_email_notifications(UserEmailNotificationsRequest $request)
    {
        $req_validated = $request->validated();
        $user = User::findOrFail($request->username);
        $user->update($req_validated);

        Log::debug('user notifications updated');
        Log::debug('require_status_email:' . $user->require_status_email);
        Log::debug('require_files_email: ' . $user->require_files_email);
        Log::debug('require_messages_email: ' . $user->require_messages_email);

        return new UserResource($user);
    }
}
