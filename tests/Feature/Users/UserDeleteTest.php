<?php

namespace Tests\Feature\users;

use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class UserDeleteTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/users/';
    private const METHOD = 'delete';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_delete_user_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $other_user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $other_user->username)
            ->assertStatus(403);
    }

    public function test_client_delete_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $other_user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $other_user->username)
            ->assertStatus(403);
    }

    public function test_worker_delete_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::WORKER));
        $other_user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $other_user->username)
            ->assertStatus(403);
    }

    public function test_validator_delete_user_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::VALIDATOR));
        $other_user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $other_user->username)
            ->assertStatus(403);
    }

    public function test_admin_delete_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $user->username)
            ->assertStatus(200);
    }

    public function test_admin_delete_other_user_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $other_user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $other_user->username)
            ->assertStatus(200);
    }
}
