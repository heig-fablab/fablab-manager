<?php

namespace Tests\Feature\Files;

use App\Models\File;
use App\Models\FileType;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class FileStoreTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/files';

    // Important: all fake files create same hash
    // It is because we can't change the file content

    public function tearDown(): void
    {
        Storage::deleteDirectory(File::PRIVATE_FILE_STORAGE_PATH);
        parent::tearDown();
    }

    //-------------------------
    // Roles and success tests
    public function test_anonymous_add_file_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_assigned_test_job($user->username);
        $file = TestHelpers::create_test_file();

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'file' => $file,
                'job_id' => $job->id
            ])
            ->assertStatus(403);

        TestHelpers::assert_file_missing_in_storage($file);
    }

    public function test_worker_add_file_job_as_worker_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);
        $file = TestHelpers::create_test_file();

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'file' => $file,
                'job_id' => $job->id
            ])
            ->assertStatus(403);

        TestHelpers::assert_file_missing_in_storage($file);
    }

    public function test_validator_add_file_job_as_validator_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::VALIDATOR));
        $job = TestHelpers::create_assigned_test_job('client.client', 'worker.worker', $user->username);
        $file = TestHelpers::create_test_file();

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'file' => $file,
                'job_id' => $job->id
            ])
            ->assertStatus(403);

        TestHelpers::assert_file_missing_in_storage($file);
    }

    public function test_client_add_file_where_isnt_in_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job();
        $file = TestHelpers::create_test_file();

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'file' => $file,
                'job_id' => $job->id
            ])
            ->assertStatus(403);

        TestHelpers::assert_file_missing_in_storage($file);
    }

    public function test_client_add_file_with_different_type_mime_type_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job($user->username);
        $file = TestHelpers::create_test_file('image.pdf', 'image/png');

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'file' => $file,
                'job_id' => $job->id
            ])
            ->assertStatus(422);

        TestHelpers::assert_file_missing_in_storage($file);
    }

    public function test_client_add_file_with_file_type_not_in_bd_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job($user->username);
        $file = TestHelpers::create_test_file('test.gif', 'image/gif');

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'file' => $file,
                'job_id' => $job->id
            ])
            ->assertStatus(422);

        TestHelpers::assert_file_missing_in_storage($file);
    }

    public function test_client_add_file_with_unaccepted_type_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job($user->username);
        $file = TestHelpers::create_test_file('test.png', 'image/png');

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'file' => $file,
                'job_id' => $job->id
            ])
            ->assertStatus(422);

        TestHelpers::assert_file_missing_in_storage($file);
    }

    public function test_client_add_file_too_big_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job($user->username);
        $file = TestHelpers::create_test_file('document.pdf', 'application/pdf', 10_001);

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'file' => $file,
                'job_id' => $job->id
            ])
            ->assertStatus(422);

        TestHelpers::assert_file_missing_in_storage($file);
    }

    public function test_client_add_file_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job($user->username);
        $file = TestHelpers::create_test_file();

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'file' => $file,
                'job_id' => $job->id
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'document.pdf',
                    'file_type' => [
                        'id' => FileType::where('name', 'pdf')->first()->id,
                        'name' => 'pdf',
                        'mime_type' => 'application/pdf'
                    ],
                    'job' => [
                        'id' => $job->id,
                        'title' => $job->title,
                    ]
                ]
            ]);

        TestHelpers::assert_file_present_in_storage($file);
    }

    public function test_admin_add_file_where_isnt_in_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_assigned_test_job($user->username);
        $file = TestHelpers::create_test_file();

        $this->actingAs($user, 'api')
            ->postJson(self::ACTUAL_ROUTE, [
                'file' => $file,
                'job_id' => $job->id
            ])
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'document.pdf',
                    'file_type' => [
                        'id' => FileType::where('name', 'pdf')->first()->id,
                        'name' => 'pdf',
                        'mime_type' => 'application/pdf'
                    ],
                    'job' => [
                        'id' => $job->id,
                        'title' => $job->title,
                    ]
                ]
            ]);

        TestHelpers::assert_file_present_in_storage($file);
    }
}
