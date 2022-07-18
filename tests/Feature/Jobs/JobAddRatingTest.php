<?php

namespace Tests\Feature\Jobs;

use App\Models\JobCategory;
use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;
use App\Constants\JobStatus;

class JobAddRatingTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/jobs/rating';
    private const METHOD = 'patch';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_rating_job_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_completed_test_job($user->username);

        $payload = [
            'id' => $job->id,
            'rating' => 5
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_worker_rating_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::WORKER));
        $job = TestHelpers::create_completed_test_job($user->username);

        $payload = [
            'id' => $job->id,
            'rating' => 5
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_validator_rating_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::VALIDATOR));
        $job = TestHelpers::create_completed_test_job($user->username);

        $payload = [
            'id' => $job->id,
            'rating' => 5
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_client_rating_job_not_client_in_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_completed_test_job('client.client');

        $payload = [
            'id' => $job->id,
            'rating' => 5
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_client_rating_job_without_worker_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job($user->username);
        $job->status = JobStatus::COMPLETED;
        $job->save();

        $payload = [
            'id' => $job->id,
            'rating' => 5
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(400);
    }

    public function test_client_rating_job_not_completed_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job($user->username);
        $job->worker_username = 'worker.worker';
        $job->save();

        $payload = [
            'id' => $job->id,
            'rating' => 5
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(400);
    }

    public function test_client_rating_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_completed_test_job($user->username);

        $payload = [
            'id' => $job->id,
            'rating' => 5
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
                    'rating' => 5,
                    'working_hours' => 2,
                    'status' => JobStatus::CLOSED,
                    'job_category' => [
                        'id' => 3,
                        'acronym' => JobCategory::find(3)->acronym,
                        'name' => JobCategory::find(3)->name,
                    ],
                    'client' => [
                        'username' => $user->username,
                        'name' => $user->name,
                        'surname' => $user->surname,
                    ],
                    'worker' => [
                        'username' => 'worker.worker',
                        'name' => 'worker',
                        'surname' => 'worker',
                    ],
                    'validator' => [
                        'username' => 'validato.validato',
                        'name' => 'validator',
                        'surname' => 'validator',
                    ],
                ]
            ]);
    }

    public function test_admin_rating_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_completed_test_job($user->username);

        $payload = [
            'id' => $job->id,
            'rating' => 5
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
                    'rating' => 5,
                    'working_hours' => 2,
                    'status' => JobStatus::CLOSED,
                    'job_category' => [
                        'id' => 3,
                        'acronym' => JobCategory::find(3)->acronym,
                        'name' => JobCategory::find(3)->name,
                    ],
                    'client' => [
                        'username' => $user->username,
                        'name' => $user->name,
                        'surname' => $user->surname,
                    ],
                    'worker' => [
                        'username' => 'worker.worker',
                        'name' => 'worker',
                        'surname' => 'worker',
                    ],
                    'validator' => [
                        'username' => 'validato.validato',
                        'name' => 'validator',
                        'surname' => 'validator',
                    ],
                ]
            ]);
    }

    public function test_admin_get_rating_not_participate_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_completed_test_job();

        $payload = [
            'id' => $job->id,
            'rating' => 5
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
                    'rating' => 5,
                    'working_hours' => 2,
                    'status' => JobStatus::CLOSED,
                    'job_category' => [
                        'id' => 3,
                        'acronym' => JobCategory::find(3)->acronym,
                        'name' => JobCategory::find(3)->name,
                    ],
                    'client' => [
                        'username' => 'client.client',
                        'name' => 'client',
                        'surname' => 'client',
                    ],
                    'worker' => [
                        'username' => 'worker.worker',
                        'name' => 'worker',
                        'surname' => 'worker',
                    ],
                    'validator' => [
                        'username' => 'validato.validato',
                        'name' => 'validator',
                        'surname' => 'validator',
                    ],
                ]
            ]);
    }
}
