<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreUserRequest;
use App\Http\Requests\UpdateRequests\UpdateUserEmailNotificationsRequest;
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

    // Others functions
    /*public function logout(Request $request) //Called when the user wants to disconnect
    {
        return redirect("shibboleth-logout");
    } //return : route to shibboleth logout handler*/

    public function update_email_notifications(UpdateUserEmailNotificationsRequest $request)
    {
        $req_validated = $request->validated();
        $user = User::findOrFail($request->switch_uuid);
        $user->update($req_validated);

        Log::debug('user updated');
        Log::debug('require_status_email:' . $user->require_status_email);
        Log::debug('require_files_email: ' . $user->require_files_email);
        Log::debug('require_messages_email: ' . $user->require_messages_email);

        return new UserResource($user);
    }
}
