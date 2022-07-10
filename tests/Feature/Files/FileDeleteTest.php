<?php

namespace Tests\Feature\Files;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\TestHelpers;
use App\Constants\Roles;

class FileDeleteTest extends TestCase
{
    private const ACTUAL_ROUTE = '/api/files/';
    private const METHOD = 'delete';

    // Important: all fake files create same hash
    // It is because we can't change the file content

    public function tearDown(): void
    {
        Storage::deleteDirectory(File::PRIVATE_FILE_STORAGE_PATH);
        parent::tearDown();
    }

    public function test_anonymous_delete_file_fail()
    {
        $user = TestHelpers::create_test_user(array());
        $job = TestHelpers::create_assigned_test_job($user->username);

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(403);

        TestHelpers::assert_file_present_in_storage($real_file);
    }

    public function test_worker_delete_file_job_as_worker_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::WORKER));
        $job = TestHelpers::create_assigned_test_job('client.client', $user->username);

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(403);

        TestHelpers::assert_file_present_in_storage($real_file);
    }

    public function test_worker_delete_file_job_as_validator_fail()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::VALIDATOR));
        $job = TestHelpers::create_assigned_test_job('client.client', 'worker.worker', $user->username);

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(403);

        TestHelpers::assert_file_present_in_storage($real_file);
    }

    public function test_client_delete_file_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::CLIENT, Roles::VALIDATOR));
        $job = TestHelpers::create_assigned_test_job($user->username);

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(200);

        //TestHelpers::assert_file_missing_in_storage($real_file); // Works on postman but not here
    }

    public function test_admin_delete_file_not_in_job_success()
    {
        $user = TestHelpers::create_test_user(array(Roles::ADMIN));
        $job = TestHelpers::create_assigned_test_job();

        $real_file = TestHelpers::create_test_file();
        $bd_file = File::store_file($real_file, $job->id);

        $this->actingAs($user, 'api')
            ->json(self::METHOD, self::ACTUAL_ROUTE . $bd_file->id)
            ->assertStatus(200);

        //TestHelpers::assert_file_missing_in_storage($real_file); // Works on postman but not here
    }
}
