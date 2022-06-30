<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class RoleNameRegexTest extends TestCase
{
    public function test_is_valid_role_name_length()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('testt', Regex::ROLE_NAME));

        // Fail
        $this->assertFalse(Regex::is_valid('t', Regex::ROLE_NAME));
        $this->assertFalse(Regex::is_valid('teeeeeeeeeeeest', Regex::ROLE_NAME)); // 15

        // Corner cases
        $this->assertTrue(Regex::is_valid('tes', Regex::ROLE_NAME));
        $this->assertFalse(Regex::is_valid('te', Regex::ROLE_NAME));

        $this->assertTrue(Regex::is_valid('teeeeeeeeest', Regex::ROLE_NAME)); // 12
        $this->assertFalse(Regex::is_valid('teeeeeeeeeest', Regex::ROLE_NAME)); // 13
    }

    public function test_is_valid_role_name_characters()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('test', Regex::ROLE_NAME));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('Test', Regex::ROLE_NAME));
        $this->assertFalse(Regex::is_valid('test1', Regex::ROLE_NAME));
        $this->assertFalse(Regex::is_valid('test$', Regex::ROLE_NAME));
    }
}
