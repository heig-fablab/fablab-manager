<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Constants\Roles;
use Tests\TestHelpers;

class JobGetOneTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/jobs/';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_get_job_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(403);
    }

    public function test_client_get_job_not_participate_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job('client.client');

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(403);
    }

    public function test_client_get_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => 'new',
                    'job_category_id' => 1,
                    'client_username' => $user->username,
                    'worker_username' => null,
                    'validator_username' => null,
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }

    public function test_worker_get_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => 'new',
                    'job_category_id' => 1,
                    'client_username' => $user->username,
                    'worker_username' => null,
                    'validator_username' => null,
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }

    public function test_validator_get_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::VALIDATOR));
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => 'new',
                    'job_category_id' => 1,
                    'client_username' => $user->username,
                    'worker_username' => null,
                    'validator_username' => null,
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }

    public function test_admin_get_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_test_job($user->username);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => 'new',
                    'job_category_id' => 1,
                    'client_username' => $user->username,
                    'worker_username' => null,
                    'validator_username' => null,
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }

    public function test_admin_get_job_not_participate_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_test_job('client.client');

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => 'new',
                    'job_category_id' => 1,
                    'client_username' => 'client.client',
                    'worker_username' => null,
                    'validator_username' => null,
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }
}
