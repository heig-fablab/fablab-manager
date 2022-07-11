<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Constants\Roles;
use Tests\TestHelpers;

class JobUpdateNotificationsTest extends TestCase
{
    private const ACTUAL_ROUTE_START = '/api/jobs/';
    private const ACTUAL_ROUTE_END = '/notifications/user/';
    private const METHOD = 'patch';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_update_notifications_job_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE_START . $job->id . self::ACTUAL_ROUTE_END . $user->username)
            ->assertStatus(403);
    }

    public function test_client_update_notifications_job_not_client_in_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job();

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE_START . $job->id . self::ACTUAL_ROUTE_END . 'client.client')
            ->assertStatus(403);
    }

    public function test_client_update_notifications_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE_START . $job->id . self::ACTUAL_ROUTE_END . $user->username)
            ->assertStatus(200);
    }

    public function test_worker_update_notifications_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE_START . $job->id . self::ACTUAL_ROUTE_END . $user->username)
            ->assertStatus(200);
    }

    public function test_validator_update_notifications_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::VALIDATOR));
        $job = TestHelpers::create_assigned_test_job('client.client', 'worker.worker', $user->username);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE_START . $job->id . self::ACTUAL_ROUTE_END . $user->username)
            ->assertStatus(200);
    }

    public function test_admin_update_notifications_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_assigned_test_job($user->username);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE_START . $job->id . self::ACTUAL_ROUTE_END . $user->username)
            ->assertStatus(200);
    }

    public function test_admin_update_notifications_job_not_participate_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_test_job();

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE_START . $job->id . self::ACTUAL_ROUTE_END . 'client.client')
            ->assertStatus(200);
    }
}
