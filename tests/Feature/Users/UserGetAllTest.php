<?php

namespace Tests\Feature\Messages;

use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class UserGetAllTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/messages';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_get_messages_fail()
    {
        $user = TestHelpers::create_test_user(array());

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE)
            ->assertStatus(403);
    }

    public function test_client_get_messages_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE)
            ->assertStatus(403);
    }

    public function test_worker_get_messages_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::WORKER));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE)
            ->assertStatus(403);
    }

    public function test_validator_get_messages_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::VALIDATOR));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE)
            ->assertStatus(403);
    }

    public function test_admin_get_messages_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE)
            ->assertStatus(200);
    }
}
