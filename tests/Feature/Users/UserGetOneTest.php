<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class UserGetOneTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/users/';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_get_job_fail()
    {
        $user = TestHelpers::create_test_user(array());

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $user->username)
            ->assertStatus(403);
    }

    public function test_user_get_other_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $other_user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $other_user->username)
            ->assertStatus(403);
    }

    public function test_user_get_own_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $user->username)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => $user->username,
                    'email' => $user->email,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'require_status_email' => 1,
                    'require_files_email' => 1,
                    'require_messages_email' => 1,
                    "roles" => [
                        "client"
                    ]
                ]
            ]);
    }

    public function test_admin_get_other_user_success()
    {
        $admin_user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $other_user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $this->actingAs($admin_user, 'api')
            ->get(self::ACTUAL_ROUTE . $other_user->username)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => $other_user->username,
                    'email' => $other_user->email,
                    'name' => $other_user->name,
                    'surname' => $other_user->surname,
                    'require_status_email' => 1,
                    'require_files_email' => 1,
                    'require_messages_email' => 1,
                    "roles" => [
                        "client"
                    ]
                ]
            ]);
    }
}
