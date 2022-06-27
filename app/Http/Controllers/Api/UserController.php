<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreUserRequest;
use App\Http\Requests\UpdateRequests\UpdateUserRequest;
use App\Http\Requests\UpdateRequests\UpdateUserEmailNotificationsRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Role;
use App\Constants\Roles;

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
        $user->roles = $user->roles;
        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        // Add client role by default
        $user->roles()->attach(Role::where('name', Roles::CLIENT)->first()->id);

        // Add other roles
        // For the moment not active, to see which right we gives to this route
        // Perhaps only update or a specific route will accept roles to be sure that admin can access
        /*foreach ($request->roles as $role_name) {
            $user->roles()->attach(Role::where('name', $role_name)->first()->id);
        }*/

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request)
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
    /*public function logout(Request $request) //Called when the user wants to disconnect
    {
        return redirect("shibboleth-logout");
    } //return : route to shibboleth logout handler*/

    public function update_email_notifications(UpdateUserEmailNotificationsRequest $request)
    {
        $req_validated = $request->validated();
        $user = User::findOrFail($request->username);
        $user->update($req_validated);

        Log::debug('user updated');
        Log::debug('require_status_email:' . $user->require_status_email);
        Log::debug('require_files_email: ' . $user->require_files_email);
        Log::debug('require_messages_email: ' . $user->require_messages_email);

        return new UserResource($user);
    }
}
