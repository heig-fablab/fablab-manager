<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class UserUpdateTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/users';
    private const METHOD = 'put';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_update_user_fail()
    {
        $user = TestHelpers::create_test_user(array());

        $payload = [
            'username' => $user->username,
            'email' => 'test@test.test',
            'name' => 'test',
            'surname' => 'test',
            'roles' => [
                Roles::WORKER,
                Roles::ADMIN
            ],
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_client_update_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $payload = [
            'username' => $user->username,
            'email' => 'test@test.test',
            'name' => 'test',
            'surname' => 'test',
            'roles' => [
                Roles::WORKER,
                Roles::ADMIN
            ],
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_worker_update_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::WORKER));

        $payload = [
            'username' => $user->username,
            'email' => 'test@test.test',
            'name' => 'test',
            'surname' => 'test',
            'roles' => [
                Roles::WORKER,
                Roles::ADMIN
            ],
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_validator_update_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::VALIDATOR));

        $payload = [
            'username' => $user->username,
            'email' => 'test@test.test',
            'name' => 'test',
            'surname' => 'test',
            'roles' => [
                Roles::WORKER,
                Roles::ADMIN
            ],
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_admin_update_user_with_existing_email_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $payload = [
            'username' => $user->username,
            'email' => 'worker@heig-vd.ch',
            'name' => 'test',
            'surname' => 'test',
            'roles' => [
                Roles::WORKER,
                Roles::VALIDATOR
            ],
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(400);
    }

    public function test_admin_update_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $payload = [
            'username' => $user->username,
            'email' => 'test' . $user->name . '@test.test',
            'name' => 'test',
            'surname' => 'test',
            'roles' => [
                Roles::WORKER,
                Roles::VALIDATOR
            ],
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => $user->username,
                    'email' => 'test' . $user->name . '@test.test',
                    'name' => 'test',
                    'surname' => 'test',
                    'require_status_email' => 1,
                    'require_files_email' => 1,
                    'require_messages_email' => 1,
                    "roles" => [
                        "client",
                        "worker",
                        "validator"
                    ]
                ]
            ]);
    }

    public function test_admin_update_other_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $other_user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $payload = [
            'username' => $other_user->username,
            'email' => 'test' . $user->name . '@test.test',
            'name' => 'test',
            'surname' => 'test',
            'roles' => [
                Roles::WORKER,
                Roles::ADMIN
            ],
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => $other_user->username,
                    'email' => 'test' . $user->name . '@test.test',
                    'name' => 'test',
                    'surname' => 'test',
                    'require_status_email' => 1,
                    'require_files_email' => 1,
                    'require_messages_email' => 1,
                    "roles" => [
                        "client",
                        "worker",
                        "admin"
                    ]
                ]
            ]);
    }
}
