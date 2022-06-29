<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class MimeTypeRegexTest extends TestCase
{
    public function test_is_valid_mime_type_characters()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('test/test', Regex::MIME_TYPE));

        // Pass & Corner cases
        $this->assertTrue(Regex::is_valid('Test/Test', Regex::MIME_TYPE));
        $this->assertTrue(Regex::is_valid('test1/test1', Regex::MIME_TYPE));
        $this->assertTrue(Regex::is_valid('test/te-st', Regex::MIME_TYPE));
        $this->assertTrue(Regex::is_valid('test/te.st', Regex::MIME_TYPE));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('test/test$', Regex::MIME_TYPE));
        $this->assertFalse(Regex::is_valid('test$/test', Regex::MIME_TYPE));
        $this->assertFalse(Regex::is_valid('test/test%', Regex::MIME_TYPE));
        $this->assertFalse(Regex::is_valid('test%/test', Regex::MIME_TYPE));
    }

    public function test_is_valid_mime_type_format()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('test/test', Regex::MIME_TYPE));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('test', Regex::MIME_TYPE));
        $this->assertFalse(Regex::is_valid('test/', Regex::MIME_TYPE));

        $this->assertFalse(Regex::is_valid('test.test', Regex::MIME_TYPE));
        $this->assertFalse(Regex::is_valid('test_test', Regex::MIME_TYPE));
        $this->assertFalse(Regex::is_valid('test$test', Regex::MIME_TYPE));
    }
}
