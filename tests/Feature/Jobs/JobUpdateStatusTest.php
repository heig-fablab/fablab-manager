<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;
use App\Constants\JobStatus;

class JobUpdateStatusTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/jobs/status';
    private const METHOD = 'patch';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_update_status_job_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $payload = [
            'id' => $job->id,
            'status' => JobStatus::ONGOING,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_client_update_status_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $payload = [
            'id' => $job->id,
            'status' => JobStatus::ONGOING,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_validator_update_status_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::VALIDATOR));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $payload = [
            'id' => $job->id,
            'status' => JobStatus::ONGOING,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_worker_update_status_job_not_worker_in_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_assigned_test_job('client.client', 'worker.worker');

        $payload = [
            'id' => $job->id,
            'status' => JobStatus::ONGOING,
            'worker_username' => 'worker.worker'
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_worker_update_status_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $payload = [
            'id' => $job->id,
            'status' => JobStatus::ONGOING,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::ONGOING,
                    'job_category_id' => 1,
                    'client_username' => 'client.client',
                    'worker_username' => $user->username,
                    'validator_username' => 'validato.validato',
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }

    public function test_admin_update_status_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $payload = [
            'id' => $job->id,
            'status' => JobStatus::ONGOING,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::ONGOING,
                    'job_category_id' => 1,
                    'client_username' => 'client.client',
                    'worker_username' => $user->username,
                    'validator_username' => 'validato.validato',
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }

    public function test_admin_update_status_job_not_participate_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_assigned_test_job('client.client', 'worker.worker');

        $payload = [
            'id' => $job->id,
            'status' => JobStatus::ONGOING,
            'worker_username' => 'worker.worker'
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::ONGOING,
                    'job_category_id' => 1,
                    'client_username' => 'client.client',
                    'worker_username' => 'worker.worker',
                    'validator_username' => 'validato.validato',
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }

    public function test_worker_update_status_job_to_completed_without_working_hours_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $payload = [
            'id' => $job->id,
            'status' => JobStatus::COMPLETED,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(422);
    }

    public function test_worker_update_status_job_to_completed_with_working_hours_succes()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $payload = [
            'id' => $job->id,
            'status' => JobStatus::COMPLETED,
            'worker_username' => $user->username,
            'working_hours' => 1.5
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => 1.5,
                    'status' => JobStatus::COMPLETED,
                    'job_category_id' => 1,
                    'client_username' => 'client.client',
                    'worker_username' => $user->username,
                    'validator_username' => 'validato.validato',
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }
}
