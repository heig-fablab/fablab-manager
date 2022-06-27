<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class UsernameRegexTest extends TestCase
{
    public function test_is_valid_username_length()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('test.test', Regex::USERNAME));

        // Fail
        $this->assertFalse(Regex::is_valid('teeeeeeest.test', Regex::USERNAME));
        $this->assertFalse(Regex::is_valid('test.teeeeeeest', Regex::USERNAME));

        // Corner cases
        $this->assertTrue(Regex::is_valid('te.test', Regex::USERNAME));
        $this->assertTrue(Regex::is_valid('test.te', Regex::USERNAME));
        $this->assertFalse(Regex::is_valid('t.test', Regex::USERNAME));
        $this->assertFalse(Regex::is_valid('test.t', Regex::USERNAME));

        $this->assertTrue(Regex::is_valid('testtest.test', Regex::USERNAME));
        $this->assertTrue(Regex::is_valid('test.testtest', Regex::USERNAME));
        $this->assertFalse(Regex::is_valid('testtestt.test', Regex::USERNAME));
        $this->assertFalse(Regex::is_valid('test.testtestt', Regex::USERNAME));
    }

    public function test_is_valid_username_characters()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('test1.test', Regex::USERNAME));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('test.test1', Regex::USERNAME));
        $this->assertFalse(Regex::is_valid('1test.test', Regex::USERNAME));

        $this->assertFalse(Regex::is_valid('Test.test', Regex::USERNAME));
        $this->assertFalse(Regex::is_valid('test.Test', Regex::USERNAME));

        $this->assertFalse(Regex::is_valid('test/test', Regex::USERNAME));
        $this->assertFalse(Regex::is_valid('test-test', Regex::USERNAME));
        $this->assertFalse(Regex::is_valid('test_test', Regex::USERNAME));
        $this->assertFalse(Regex::is_valid('test$test', Regex::USERNAME));
    }
}
