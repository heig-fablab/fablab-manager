<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class UserUpdateNotificationsTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/users/notifications';
    private const METHOD = 'patch';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_update_notifications_user_fail()
    {
        $user = TestHelpers::create_test_user(array());

        $payload = [
            'username' => $user->username,
            'require_status_email' => false,
            'require_files_email' => true,
            'require_messages_email' => false
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_user_update_notifications_other_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $other_user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $payload = [
            'username' => $other_user->username,
            'require_status_email' => false,
            'require_files_email' => true,
            'require_messages_email' => false
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_client_update_notifications_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $payload = [
            'username' => $user->username,
            'require_status_email' => false,
            'require_files_email' => true,
            'require_messages_email' => false
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => $user->username,
                    'email' => $user->email,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'require_status_email' => 0,
                    'require_files_email' => 1,
                    'require_messages_email' => 0,
                    "roles" => [
                        "client"
                    ]
                ]
            ]);
    }

    public function test_worker_update_notifications_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));

        $payload = [
            'username' => $user->username,
            'require_status_email' => false,
            'require_files_email' => true,
            'require_messages_email' => false
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => $user->username,
                    'email' => $user->email,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'require_status_email' => 0,
                    'require_files_email' => 1,
                    'require_messages_email' => 0,
                    "roles" => [
                        "client",
                        "worker"
                    ]
                ]
            ]);
    }

    public function test_validator_update_notifications_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::VALIDATOR));

        $payload = [
            'username' => $user->username,
            'require_status_email' => false,
            'require_files_email' => true,
            'require_messages_email' => false
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => $user->username,
                    'email' => $user->email,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'require_status_email' => 0,
                    'require_files_email' => 1,
                    'require_messages_email' => 0,
                    "roles" => [
                        "client",
                        "validator"
                    ]
                ]
            ]);
    }

    public function test_admin_update_notifications_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $payload = [
            'username' => $user->username,
            'require_status_email' => false,
            'require_files_email' => true,
            'require_messages_email' => false
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => $user->username,
                    'email' => $user->email,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'require_status_email' => 0,
                    'require_files_email' => 1,
                    'require_messages_email' => 0,
                    "roles" => [
                        "admin"
                    ]
                ]
            ]);
    }

    public function test_admin_update_notifications_other_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $other_user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $payload = [
            'username' => $other_user->username,
            'require_status_email' => false,
            'require_files_email' => true,
            'require_messages_email' => false
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => $other_user->username,
                    'email' => $other_user->email,
                    'name' => $other_user->name,
                    'surname' => $other_user->surname,
                    'require_status_email' => 0,
                    'require_files_email' => 1,
                    'require_messages_email' => 0,
                    "roles" => [
                        "client"
                    ]
                ]
            ]);
    }
}
