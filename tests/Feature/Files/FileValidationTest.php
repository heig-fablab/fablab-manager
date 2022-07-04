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
        $this->assertFalse(File::is_valid_file($file, ['application/pdf']));
    }

    public function test_is_valid_file_with_different_extension_mime_type_fail()
    {
        $file = TestHelpers::create_test_file('image.pdf', 'image/png');
        $this->assertFalse(File::is_valid_file($file, ['application/pdf']));
    }

    public function test_is_valid_file_too_big_fail()
    {
        $file = TestHelpers::create_test_file('document.pdf', 'application/pdf', 1000001);
        $this->assertFalse(File::is_valid_file($file, ['application/pdf']));
    }

    public function test_is_valid_file_with_null_file_fail()
    {
        $this->assertFalse(File::is_valid_file(null, ['application/pdf']));
    }

    /*public function test_is_valid_file_success()
    {
        $file = TestHelpers::create_test_file();
        $this->assertTrue(File::is_valid_file($file, ['application/pdf']));
    }*/
}
