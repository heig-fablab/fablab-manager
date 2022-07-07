<?php

namespace Tests\Feature\Jobs;

use App\Models\JobCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestHelpers;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Constants\Roles;
use App\Constants\JobStatus;

class JobStoreTest extends TestCase
{
    /*use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');
    }*/

    private const ACTUAL_ROUTE = '/api/jobs';

    //-------------------------
    // Roles and success tests
    public function test_anonymous_add_job_without_files_fail()
    {
        $user = TestHelpers::create_test_user(array());

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'title' => 'test',
                'description' => 'test',
                'job_category_id' => 1,
                'deadline' => '2022-09-20',
                'client_username' => $user->username,
            ])
            ->assertStatus(403);
    }

    public function test_worker_add_job_without_files_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::WORKER));

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'title' => 'test',
                'description' => 'test',
                'job_category_id' => 1,
                'deadline' => '2022-09-20',
                'client_username' => $user->username,
            ])
            ->assertStatus(403);
    }

    public function test_validator_add_job_without_files_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::VALIDATOR));

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'title' => 'test',
                'description' => 'test',
                'job_category_id' => 1,
                'deadline' => '2022-09-20',
                'client_username' => $user->username,
            ])
            ->assertStatus(403);
    }

    public function test_client_add_job_without_files_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'title' => 'test',
                'description' => 'test',
                'job_category_id' => 1,
                'deadline' => '2022-09-20',
                'client_username' => $user->username,
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::NEW,
                    'job_category' => [
                        'id' => 1,
                        'acronym' => JobCategory::find(1)->acronym,
                        'name' => JobCategory::find(1)->name,
                    ],
                    'client' => [
                        'username' => $user->username,
                        'name' => $user->name,
                        'surname' => $user->surname,
                    ],
                    'worker' => null,
                    'validator' => null,
                    'files' => [],
                    'messages' => [],
                ]
            ]);
    }

    public function test_admin_add_job_without_files_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'title' => 'test',
                'description' => 'test',
                'job_category_id' => 1,
                'deadline' => '2022-09-20',
                'client_username' => $user->username,
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::NEW,
                    'job_category' => [
                        'id' => 1,
                        'acronym' => JobCategory::find(1)->acronym,
                        'name' => JobCategory::find(1)->name,
                    ],
                    'client' => [
                        'username' => $user->username,
                        'name' => $user->name,
                        'surname' => $user->surname,
                    ],
                    'worker' => null,
                    'validator' => null,
                    'files' => [],
                    'messages' => [],
                ]
            ]);
    }

    /*public function test_client_add_job_with_files_successfull()
    {
        // File upload: https://laravel.com/docs/9.x/http-tests#testing-file-uploads
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.pdf');

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'title' => 'test',
                'description' => 'test',
                'job_category_id' => 1,
                'deadline' => '2022-09-20',
                'client_username' => $user->username,
                'files[]' => [$file],
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'title' => 'test',
                    'description' => 'test',
                    'deadline' => '2022-09-20',
                    'rating' => null,
                    'working_hours' => null,
                    'status' => JobStatus::NEW,
                    'job_category' => [
                        'id' => 1,
                        'acronym' => JobCategory::find(1)->acronym,
                        'name' => JobCategory::find(1)->name,
                    ],
                    'client' => [
                        'username' => $user->username,
                        'name' => $user->name,
                        'surname' => $user->surname,
                    ],
                    'worker' => null,
                    'validator' => null,
                    'files' => [],
                    'messages' => [],
                ]
            ]);

        Storage::disk('avatars')->assertExists($file->hashName());
    }*/
}
