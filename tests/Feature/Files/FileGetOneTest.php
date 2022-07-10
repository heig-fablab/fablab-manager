<?php

namespace Tests\Feature\Files;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\TestHelpers;
use App\Models\File;
use App\Constants\Roles;

class FileGetOneTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/files/';

    // Important: all fake files create same hash
    // It is because we can't change the file content

    public function tearDown(): void
    {
        Storage::deleteDirectory(File::PRIVATE_FILE_STORAGE_PATH);
        parent::tearDown();
    }

    public function test_anonymous_get_file_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_test_job($user->username);

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(403);
    }

    public function test_client_get_file_job_not_participate_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job();

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(403);
    }

    public function test_client_get_file_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_test_job($user->username);

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'document.pdf',
                    'file_type' => [
                        'id' => 4,
                        'name' => 'pdf',
                        'mime_type' => 'application/pdf'
                    ],
                    'job' => [
                        'id' => $job->id,
                        'title' => $job->title,
                    ]
                ]
            ]);
    }

    public function test_worker_get_file_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'document.pdf',
                    'file_type' => [
                        'id' => 4,
                        'name' => 'pdf',
                        'mime_type' => 'application/pdf'
                    ],
                    'job' => [
                        'id' => $job->id,
                        'title' => $job->title,
                    ]
                ]
            ]);
    }

    public function test_validator_get_file_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::VALIDATOR));
        $job = TestHelpers::create_assigned_test_job('client.client', 'worker.worker', $user->username);

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'document.pdf',
                    'file_type' => [
                        'id' => 4,
                        'name' => 'pdf',
                        'mime_type' => 'application/pdf'
                    ],
                    'job' => [
                        'id' => $job->id,
                        'title' => $job->title,
                    ]
                ]
            ]);
    }

    public function test_admin_get_file_job_not_participate_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_test_job();

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->get(self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'document.pdf',
                    'file_type' => [
                        'id' => 4,
                        'name' => 'pdf',
                        'mime_type' => 'application/pdf'
                    ],
                    'job' => [
                        'id' => $job->id,
                        'title' => $job->title,
                    ]
                ]
            ]);
    }
}
