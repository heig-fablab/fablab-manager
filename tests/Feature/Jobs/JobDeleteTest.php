<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Constants\Roles;
use Tests\TestHelpers;

class JobDeleteTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/jobs/';
    private const METHOD = 'delete';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_delete_job_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(403);
    }

    public function test_worker_delete_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::WORKER));
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(403);
    }

    public function test_validator_delete_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::VALIDATOR));
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(403);
    }

    public function test_client_delete_job_not_client_in_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job('client.client');

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(403);
    }

    public function test_client_delete_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(200);
    }

    public function test_admin_delete_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(200);
    }
}
