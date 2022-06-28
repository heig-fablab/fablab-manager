<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Role;
use App\Constants\Roles;

class JobStoreTest extends TestCase
{
    /*use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh --seed');
    }*/

    public function create_test_user(array $roles): User
    {
        $user = User::factory()->create();
        foreach ($roles as $role) {
            $user->roles()->attach(Role::where('name', $role)->first());
        }
        $user->save();
        return $user;
    }

    public function test_anonymous_add_job_without_files_fail()
    {
        $user = $this->create_test_user(array());

        $this->actingAs($user, 'api')
            ->postJson('/api/jobs', [
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
        $user = $this->create_test_user(array(Roles::WORKER));

        $this->actingAs($user, 'api')
            ->postJson('/api/jobs', [
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
        $user = $this->create_test_user(array(Roles::VALIDATOR));

        $this->actingAs($user, 'api')
            ->postJson('/api/jobs', [
                'title' => 'test',
                'description' => 'test',
                'job_category_id' => 1,
                'deadline' => '2022-09-20',
                'client_username' => $user->username,
            ])
            ->assertStatus(403);
    }

    public function test_client_add_job_without_files_successfull()
    {
        $user = $this->create_test_user(array(Roles::CLIENT));

        $this->actingAs($user, 'api')
            ->postJson('/api/jobs', [
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

    public function test_admin_add_job_without_files_successfull()
    {
        $user = $this->create_test_user(array(Roles::ADMIN));

        $this->actingAs($user, 'api')
            ->postJson('/api/jobs', [
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

    /*public function test_client_add_job_with_files_successfull()
    {
        // File upload: https://laravel.com/docs/9.x/http-tests#testing-file-uploads
        $user = $this->create_test_user(array(Roles::CLIENT));

        Storage::fake('avatars');

        $file = UploadedFile::fake()->image('avatar.pdf');

        $this->actingAs($user, 'api')
            ->postJson('/api/jobs', [
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

        Storage::disk('avatars')->assertExists($file->hashName());
    }*/
}
