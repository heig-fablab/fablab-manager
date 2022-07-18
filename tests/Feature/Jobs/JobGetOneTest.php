<?php

namespace Tests\Feature\Jobs;

use App\Constants\JobStatus;
use App\Models\JobCategory;
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
                    'id' => $job->id,
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => TestHelpers::deadline(),
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::NEW,
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
                    'worker' => null,
                    'validator' => null,
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
                    'id' => $job->id,
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => TestHelpers::deadline(),
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::NEW,
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
                    'worker' => null,
                    'validator' => null,
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
                    'id' => $job->id,
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => TestHelpers::deadline(),
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::NEW,
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
                    'worker' => null,
                    'validator' => null,
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
                    'id' => $job->id,
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => TestHelpers::deadline(),
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::NEW,
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
                    'worker' => null,
                    'validator' => null,
                ]
            ]);
    }

    public function test_admin_get_job_not_participate_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_test_job();

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $job->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $job->id,
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => TestHelpers::deadline(),
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::NEW,
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
                    'worker' => null,
                    'validator' => null,
                ]
            ]);
    }
}
