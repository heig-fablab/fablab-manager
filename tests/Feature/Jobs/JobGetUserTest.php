<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Constants\Roles;
use Tests\TestHelpers;

class JobGetUserTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/jobs/user/';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_get_user_jobs_fail()
    {
        $user = TestHelpers::create_test_user(array());

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $user->username)
            ->assertStatus(403);
    }

    public function test_client_get_user_jobs_from_other_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . 'client.client')
            ->assertStatus(403);
    }

    public function test_client_get_user_jobs_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $user->username)
            ->assertStatus(200);
    }

    public function test_worker_get_user_jobs_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $user->username)
            ->assertStatus(200);
    }

    public function test_validator_get_user_jobs_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::VALIDATOR));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $user->username)
            ->assertStatus(200);
    }

    public function test_admin_get_user_jobs_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $user->username)
            ->assertStatus(200);
    }
}
