<?php

namespace Tests\Feature\Jobs;

use Tests\TestCase;
use App\Constants\Roles;
use Tests\TestHelpers;

class JobUpdateTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/jobs';
    private const METHOD = 'put';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_update_job_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_test_job($user->username);

        $payload = [
            'id' => $job->id,
            'title' => 'test2',
            'description' => 'test2',
            'deadline' => '2022-10-20',
            'job_category_id' => 2
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_worker_update_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::WORKER));
        $job = TestHelpers::create_test_job($user->username);

        $payload = [
            'id' => $job->id,
            'title' => 'test2',
            'description' => 'test2',
            'deadline' => '2022-10-20',
            'job_category_id' => 2
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_validator_update_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::VALIDATOR));
        $job = TestHelpers::create_test_job($user->username);

        $payload = [
            'id' => $job->id,
            'title' => 'test2',
            'description' => 'test2',
            'deadline' => '2022-10-20',
            'job_category_id' => 2
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_client_update_job_not_client_in_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job('client.client');

        $payload = [
            'id' => $job->id,
            'title' => 'test2',
            'description' => 'test2',
            'deadline' => '2022-09-20',
            'job_category_id' => 2
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);
    }

    public function test_client_update_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job($user->username);

        $payload = [
            'id' => $job->id,
            'title' => 'test2',
            'description' => 'test2',
            'deadline' => '2022-10-20',
            'job_category_id' => 2
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test2',
                    'description' => 'test2',
                    'deadline' => '2022-10-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => 'new',
                    'job_category_id' => 2,
                    'client_username' => $user->username,
                    'worker_username' => null,
                    'validator_username' => null,
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }

    public function test_admin_update_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_test_job($user->username);

        $payload = [
            'id' => $job->id,
            'title' => 'test2',
            'description' => 'test2',
            'deadline' => '2022-10-20',
            'job_category_id' => 2
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test2',
                    'description' => 'test2',
                    'deadline' => '2022-10-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => 'new',
                    'job_category_id' => 2,
                    'client_username' => $user->username,
                    'worker_username' => null,
                    'validator_username' => null,
                    'files' => [],
                    'messages' => [],
                    'events' => [],
                ]
            ]);
    }

    public function test_admin_update_job_not_participate_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_test_job('client.client');

        $payload = [
            'id' => $job->id,
            'title' => 'test2',
            'description' => 'test2',
            'deadline' => '2022-10-20',
            'job_category_id' => 2
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'test2',
                    'description' => 'test2',
                    'deadline' => '2022-10-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => 'new',
                    'job_category_id' => 2,
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
