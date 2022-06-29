<?php

namespace Files;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\TestHelpers;

class FileValidationTest extends TestCase
{
    public function tearDown(): void
    {
        Storage::deleteDirectory(File::FILE_STORAGE_PATH);
        parent::tearDown();
    }

    public function test_is_valid_file_not_in_job_category_accepted_types_fail()
    {
        $file = TestHelpers::create_test_file('image.png', 'image/png');
        $this->assertFalse(File::is_valid_file($file, 1, 1));
    }

    public function test_is_valid_file_with_different_extension_mime_type_fail()
    {
        $file = TestHelpers::create_test_file('image.pdf', 'image/png');
        $this->assertFalse(File::is_valid_file($file, 1, 1));
    }

    public function test_is_valid_file_too_big_fail()
    {
        $file = TestHelpers::create_test_file('document.pdf', 'application/pdf', 1000001);
        $this->assertFalse(File::is_valid_file($file, 1, 1));
    }

    public function test_is_valid_file_with_null_file_success()
    {
        $this->assertFalse(File::is_valid_file(null, 1, 1));
    }

    public function test_is_valid_file_with_bad_job_id_and_job_category_id_fail()
    {
        $file = TestHelpers::create_test_file();
        $this->assertFalse(File::is_valid_file($file, -1, -1));
    }

    /*public function test_is_valid_file_with_job_id_success()
    {
        $job = TestHelpers::create_assigned_test_job();
        $file = TestHelpers::create_test_file();
        $this->assertTrue(File::is_valid_file($file, -1, $job->id));
    }

    public function test_is_valid_file_with_job_category_id_success()
    {
        $job = TestHelpers::create_assigned_test_job();
        $file = TestHelpers::create_test_file();
        $this->assertTrue(File::is_valid_file($file, $job->job_category->id, -1));
    }*/
}
