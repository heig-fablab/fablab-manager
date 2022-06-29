<?php

namespace Tests\Feature\Jobs;

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
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => 5,
                    'working_hours' => 2,
                    'status' => JobStatus::CLOSED,
                    'job_category_id' => 1,
                    'client_username' => $user->username,
                    'worker_username' => 'worker.worker',
                    'validator_username' => 'validato.validato',
                    'files' => [],
                    'messages' => [],
                    'events' => [],
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
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => 5,
                    'working_hours' => 2,
                    'status' => JobStatus::CLOSED,
                    'job_category_id' => 1,
                    'client_username' => $user->username,
                    'worker_username' => 'worker.worker',
                    'validator_username' => 'validato.validato',
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }

    public function test_admin_get_rating_not_participate_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_completed_test_job('client.client');

        $payload = [
            'id' => $job->id,
            'rating' => 5
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => 5,
                    'working_hours' => 2,
                    'status' => JobStatus::CLOSED,
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
}
