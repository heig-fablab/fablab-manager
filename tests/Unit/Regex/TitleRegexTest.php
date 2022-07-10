<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class TitleRegexTest extends TestCase
{
    public function test_is_valid_title_length()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('testtest', Regex::TITLE));

        // Fail
        $this->assertFalse(Regex::is_valid('', Regex::TITLE));
        $this->assertFalse(Regex::is_valid('teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest', Regex::TITLE)); // 55

        // Corner cases
        $this->assertTrue(Regex::is_valid('te', Regex::TITLE));
        $this->assertFalse(Regex::is_valid('t', Regex::TITLE));

        $this->assertTrue(Regex::is_valid('teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest', Regex::TITLE)); // 50
        $this->assertFalse(Regex::is_valid('teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest', Regex::TITLE)); // 51
    }

    public function test_is_valid_title_characters()
    {
        // Pass & Corner cases
        $this->assertTrue(Regex::is_valid('testtest', Regex::TITLE));
        $this->assertTrue(Regex::is_valid('Testtest', Regex::TITLE));
        $this->assertTrue(Regex::is_valid('Testtest1', Regex::TITLE));
        $this->assertTrue(Regex::is_valid('-_/', Regex::TITLE));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('test$', Regex::TITLE));
        $this->assertFalse(Regex::is_valid('test%', Regex::TITLE));
        $this->assertFalse(Regex::is_valid('test&', Regex::TITLE));
    }
}
