<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class UserStoreTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/users';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_add_user_fail()
    {
        $user = TestHelpers::create_test_user(array());

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'username' => 'test.test',
                'email' => 'test' . $user->name . '@test.test',
                'name' => 'test',
                'surname' => 'test'
            ])
            ->assertStatus(403);
    }

    public function test_client_add_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'username' => 'test.test',
                'email' => 'test' . $user->name . '@test.test',
                'name' => 'test',
                'surname' => 'test'
            ])
            ->assertStatus(403);
    }

    public function test_worker_add_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::WORKER));

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'username' => 'test.test',
                'email' => 'test' . $user->name . '@test.test',
                'name' => 'test',
                'surname' => 'test'
            ])
            ->assertStatus(403);
    }

    public function test_validator_add_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::VALIDATOR));

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'username' => 'test.test',
                'email' => 'test' . $user->name . '@test.test',
                'name' => 'test',
                'surname' => 'test'
            ])
            ->assertStatus(403);
    }

    public function test_admin_add_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'username' => 'test.test',
                'email' => 'test' . $user->name . '@test.test',
                'name' => 'test',
                'surname' => 'test'
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'username' => 'test.test',
                    'email' => 'test' . $user->name . '@test.test',
                    'name' => 'test',
                    'surname' => 'test',
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
