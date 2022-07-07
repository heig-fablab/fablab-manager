<?php

namespace Tests\Feature\Files;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class FileUpdateTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/files';
    private const METHOD = 'put';

    // Important: all fake files create same hash
    // It is because we can't change the file content

    public function tearDown(): void
    {
        Storage::deleteDirectory(File::PRIVATE_FILE_STORAGE_PATH);
        parent::tearDown();
    }

    //-------------------------
    // Roles and success tests
    public function test_anonymous_update_file_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $real_file = TestHelpers::create_test_file();
        $update_file = TestHelpers::create_test_file('document2.pdf');
        $bd_file = File::store_file($real_file, $job->id);

        $payload = [
            'id' => $bd_file->id,
            'job_id' => $job->id,
            'file' => $update_file
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);

        TestHelpers::assert_file_present_in_storage($real_file);
        //TestHelpers::assert_file_missing_in_storage($update_file); //Doesn't work with fake files
    }

    public function test_worker_update_file_job_as_worker_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $real_file = TestHelpers::create_test_file();
        $update_file = TestHelpers::create_test_file('document2.pdf');
        $bd_file = File::store_file($real_file, $job->id);

        $payload = [
            'id' => $bd_file->id,
            'job_id' => $job->id,
            'file' => $update_file
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);

        TestHelpers::assert_file_present_in_storage($real_file);
        //TestHelpers::assert_file_missing_in_storage($update_file); //Doesn't work with fake files
    }

    public function test_validator_update_file_job_as_validator_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::VALIDATOR));
        $job = TestHelpers::create_assigned_test_job('client.client', 'worker.worker', $user->username);

        $real_file = TestHelpers::create_test_file();
        $update_file = TestHelpers::create_test_file('document2.pdf');
        $bd_file = File::store_file($real_file, $job->id);

        $payload = [
            'id' => $bd_file->id,
            'job_id' => $job->id,
            'file' => $update_file
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);

        TestHelpers::assert_file_present_in_storage($real_file);
        //TestHelpers::assert_file_missing_in_storage($update_file); //Doesn't work with fake files
    }

    public function test_client_update_file_where_isnt_in_job_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job();

        $real_file = TestHelpers::create_test_file();
        $update_file = TestHelpers::create_test_file('document2.pdf');
        $bd_file = File::store_file($real_file, $job->id);

        $payload = [
            'id' => $bd_file->id,
            'job_id' => $job->id,
            'file' => $update_file
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(403);

        TestHelpers::assert_file_present_in_storage($real_file);
        //TestHelpers::assert_file_missing_in_storage($update_file); //Doesn't work with fake files
    }

    public function test_client_update_file_too_big_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job($user->username);

        $real_file = TestHelpers::create_test_file();
        $update_file = TestHelpers::create_test_file('document2.pdf', 'application/pdf', 10_001);
        $bd_file = File::store_file($real_file, $job->id);

        $payload = [
            'id' => $bd_file->id,
            'job_id' => $job->id,
            'file' => $update_file
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(422);

        TestHelpers::assert_file_present_in_storage($real_file);
        //TestHelpers::assert_file_missing_in_storage($update_file); //Doesn't work with fake files
    }

    public function test_client_update_file_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT));
        $job = TestHelpers::create_assigned_test_job($user->username);

        $real_file = TestHelpers::create_test_file();
        $update_file = TestHelpers::create_test_file('document2.pdf');
        $bd_file = File::store_file($real_file, $job->id);

        $payload = [
            'id' => $bd_file->id,
            'job_id' => $job->id,
            'file' => $update_file
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $bd_file->id,
                    'name' => $update_file->name,
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

        TestHelpers::assert_file_present_in_storage($update_file);
        //TestHelpers::assert_file_missing_in_storage($real_file); //Doesn't work with fake files
    }

    public function test_admin_update_file_where_isnt_in_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_assigned_test_job($user->username);

        $real_file = TestHelpers::create_test_file();
        $update_file = TestHelpers::create_test_file('document2.pdf');
        $bd_file = File::store_file($real_file, $job->id);

        $payload = [
            'id' => $bd_file->id,
            'job_id' => $job->id,
            'file' => $update_file
        ];

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE, $payload)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $bd_file->id,
                    'name' => $update_file->name,
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
        TestHelpers::assert_file_present_in_storage($update_file);
        //TestHelpers::assert_file_missing_in_storage($real_file); //Doesn't work with fake files
    }
}
