<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class FileTypeNameRegexTest extends TestCase
{
    public function test_is_valid_file_type_name_length()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('testtest', Regex::FILE_TYPE_NAME));

        // Fail
        $this->assertFalse(Regex::is_valid('t', Regex::FILE_TYPE_NAME));
        $this->assertFalse(Regex::is_valid('teeeeeeeeeeeest', Regex::FILE_TYPE_NAME)); // 15

        // Corner cases
        $this->assertTrue(Regex::is_valid('te', Regex::FILE_TYPE_NAME));
        $this->assertFalse(Regex::is_valid('t', Regex::FILE_TYPE_NAME));

        $this->assertTrue(Regex::is_valid('teeeeeeest', Regex::FILE_TYPE_NAME)); // 10
        $this->assertFalse(Regex::is_valid('teeeeeeeest', Regex::FILE_TYPE_NAME)); // 11
    }

    public function test_is_valid_file_type_name_characters()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('test', Regex::FILE_TYPE_NAME));
        $this->assertTrue(Regex::is_valid('test1', Regex::FILE_TYPE_NAME));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('Test', Regex::FILE_TYPE_NAME));
        $this->assertFalse(Regex::is_valid('test$', Regex::FILE_TYPE_NAME));
    }
}
