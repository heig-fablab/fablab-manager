<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class PasswordRegexTest extends TestCase
{
    public function test_is_valid_password_length()
    {
        // Pass
        $this->assertTrue(Regex::is_valid_password("Test123456789$"));

        // Fail
        $this->assertTrue(!Regex::is_valid_password("Te1$"));
        $this->assertTrue(!Regex::is_valid_password("Teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest1$")); // 100 chars

        // Corner cases
        $this->assertTrue(Regex::is_valid_password("Test123$")); // 8 chars
        $this->assertTrue(Regex::is_valid_password("Teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest1$")); // 64 chars
        $this->assertTrue(!Regex::is_valid_password("Test12$")); // 7 chars
        $this->assertTrue(!Regex::is_valid_password("Teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest1$")); // 65 chars
    }

    public function test_is_valid_password_characters()
    {
        // Pass
        $this->assertTrue(Regex::is_valid_password("Test123456789$"));

        // Fail & Corner cases
        $this->assertTrue(!Regex::is_valid_password("test123456789$")); // Without upper case
        $this->assertTrue(!Regex::is_valid_password("TEST123456789$")); // Without lower case
        $this->assertTrue(!Regex::is_valid_password("Testabcdefghi$")); // Without digit
        $this->assertTrue(!Regex::is_valid_password("Test1234567890")); // Without special char
        $this->assertTrue(!Regex::is_valid_password("Test123456789>")); // With a bad special char
    }
}
