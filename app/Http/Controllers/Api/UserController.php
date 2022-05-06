<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $user = User::findOrFail($switch_uuid);
        $user->roles = $user->roles;
        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        // TODO: some problem to solve
        // https://www.codimth.com/blog/web/laravel/how-use-many-many-eloquent-relationship-laravel
        //$user->roles()->attach($request->roles);

        // Example: $quiz->questions()->attach($question->id);
        //$user->roles()->attach(1);


        // It doesn't work for sure cause there is a prob with my PK
        // Error message:
        //Illuminate\Database\QueryException: SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`fablab_manager`.`role_user`, CONSTRAINT `role_user_user_switch_uuid_foreign` FOREIGN KEY (`user_switch_uuid`) REFERENCES `users` (`switch_uuid`)) (SQL: insert into `role_user` (`user_switch_uuid`, `role_id`) values (0, 4)) in file /var/www/html/vendor/laravel/framework/src/Illuminate/Database/Connection.php on line 742

        /*foreach ($request->roles as $role_id) {
            DB::table('role_user')->insert([
                'role_id' => $role_id,
                'user_switch_uuid' => $user->switch_uuid,
            ]);
        }*/

        /*foreach ($request->roles as $role_id) {
            //$role = Role::where('name', $role_name)->first();
            $user->roles()->attach($role_id);
            //$user->roles()->attach($role);
        }*/

        return new UserResource($user);
    }

    public function update(StoreUserRequest $request)
    {
        $user = User::find($request->switch_uuid);
        $user->update($request->validated());
        //$user->roles()->attach($roles);

        // TODO: some problem to solve
        foreach ($request->roles_to_add as $role_name) {
            $role = Role::where('name', $role_name)->first();
            $user->roles()->attach($role->id);
        }

        foreach ($request->roles_to_remove as $role_name) {
            $role = Role::where('name', $role_name)->first();
            $user->roles()->detach($role->id);
        }

        //$user->notify_email_updated_at = now();

        return new UserResource($user);
    }

    public function destroy($switch_uuid)
    {
        User::findOrFail($switch_uuid)->delete();
        return response()->json([
            'message' => "Device deleted successfully!"
        ], 200);
    }
}
