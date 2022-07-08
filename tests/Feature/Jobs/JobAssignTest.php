<?php

namespace Tests\Feature\Jobs;

use App\Constants\JobStatus;
use App\Models\Job;
use App\Models\JobCategory;
use Tests\TestCase;
use App\Constants\Roles;
use Tests\TestHelpers;

class JobAssignTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/jobs/worker/assign';
    private const METHOD = 'patch';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_assign_job_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_test_job();

        $payload = [
            'id' => $job->id,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_client_assign_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job();

        $payload = [
            'id' => $job->id,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_validator_assign_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::VALIDATOR));
        $job = TestHelpers::create_test_job();

        $payload = [
            'id' => $job->id,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_worker_assign_job_other_worker_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_test_job();

        $payload = [
            'id' => $job->id,
            'worker_username' => 'worker.worker'
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_worker_assign_job_with_already_jobs_limit_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_test_job();

        for ($i = 0; $i < Job::JOBS_ASSIGNED_LIMIT; $i++) {
            TestHelpers::create_assigned_test_job('client.client', $user->username);
        }

        $payload = [
            'id' => $job->id,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_worker_assign_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_test_job();

        $payload = [
            'id' => $job->id,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $job->id,
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => TestHelpers::deadline(),
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::ASSIGNED,
                    'job_category' => [
                        'id' => 1,
                        'acronym' => JobCategory::find(1)->acronym,
                        'name' => JobCategory::find(1)->name,
                    ],
                    'client' => [
                        'username' => 'client.client',
                        'name' => 'client',
                        'surname' => 'client',
                    ],
                    'worker' => [
                        'username' => $user->username,
                        'name' => $user->name,
                        'surname' => $user->surname,
                    ],
                    'validator' => null,
                ]
            ]);
    }

    public function test_admin_assign_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_test_job('client.client');

        $payload = [
            'id' => $job->id,
            'worker_username' => $user->username
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $job->id,
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => TestHelpers::deadline(),
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::ASSIGNED,
                    'job_category' => [
                        'id' => 1,
                        'acronym' => JobCategory::find(1)->acronym,
                        'name' => JobCategory::find(1)->name,
                    ],
                    'client' => [
                        'username' => 'client.client',
                        'name' => 'client',
                        'surname' => 'client',
                    ],
                    'worker' => [
                        'username' => $user->username,
                        'name' => $user->name,
                        'surname' => $user->surname,
                    ],
                    'validator' => null,
                ]
            ]);
    }

    public function test_admin_assign_job_other_worker_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $worker = TestHelpers::create_test_user(array(Roles::WORKER));
        $job = TestHelpers::create_test_job();

        $payload = [
            'id' => $job->id,
            'worker_username' => $worker->username,
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $job->id,
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => TestHelpers::deadline(),
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::ASSIGNED,
                    'job_category' => [
                        'id' => 1,
                        'acronym' => JobCategory::find(1)->acronym,
                        'name' => JobCategory::find(1)->name,
                    ],
                    'client' => [
                        'username' => 'client.client',
                        'name' => 'client',
                        'surname' => 'client',
                    ],
                    'worker' => [
                        'username' => $worker->username,
                        'name' => $worker->name,
                        'surname' => $worker->surname,
                    ],
                    'validator' => null,
                ]
            ]);
    }
}
