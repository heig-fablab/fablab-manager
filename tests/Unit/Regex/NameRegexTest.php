<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class NameRegexTest extends TestCase
{
    public function test_is_valid_name_length()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('testtest', Regex::NAME));

        // Fail
        $this->assertFalse(Regex::is_valid('t', Regex::NAME));
        $this->assertFalse(Regex::is_valid('teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest', Regex::NAME)); // 55

        // Corner cases
        $this->assertTrue(Regex::is_valid('tes', Regex::NAME));
        $this->assertFalse(Regex::is_valid('te', Regex::NAME));

        $this->assertTrue(Regex::is_valid('teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest', Regex::NAME)); // 50
        $this->assertFalse(Regex::is_valid('teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest', Regex::NAME)); // 51
    }

    public function test_is_valid_name_characters()
    {
        // Pass & Corner cases
        $this->assertTrue(Regex::is_valid('testtest', Regex::NAME));
        $this->assertTrue(Regex::is_valid('Testtest', Regex::NAME));
        $this->assertTrue(Regex::is_valid('testtest1', Regex::NAME));
        $this->assertTrue(Regex::is_valid('test-test', Regex::NAME));
        $this->assertTrue(Regex::is_valid('test_test', Regex::NAME));
        $this->assertTrue(Regex::is_valid('test test', Regex::NAME));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('test$', Regex::NAME));
        $this->assertFalse(Regex::is_valid('test%', Regex::NAME));
        $this->assertFalse(Regex::is_valid('test&', Regex::NAME));
        $this->assertFalse(Regex::is_valid('test@', Regex::NAME));
    }
}
