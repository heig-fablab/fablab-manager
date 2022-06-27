<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class DescriptionRegexTest extends TestCase
{
    public function test_is_valid_description_length()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('testtest', Regex::DESCRIPTION));

        // Fail
        $this->assertFalse(Regex::is_valid('te', Regex::DESCRIPTION));

        // Corner cases
        $this->assertTrue(Regex::is_valid('test', Regex::DESCRIPTION));
        $this->assertFalse(Regex::is_valid('tes', Regex::DESCRIPTION));
    }

    public function test_is_valid_description_characters()
    {
        // Pass & Corner cases
        $this->assertTrue(Regex::is_valid('testtest', Regex::DESCRIPTION));
        $this->assertTrue(Regex::is_valid('Testtest', Regex::DESCRIPTION));
        $this->assertTrue(Regex::is_valid('Testtest1', Regex::DESCRIPTION));
        $this->assertTrue(Regex::is_valid(' .,-_:()\/', Regex::DESCRIPTION));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('test$', Regex::DESCRIPTION));
        $this->assertFalse(Regex::is_valid('test%', Regex::DESCRIPTION));
        $this->assertFalse(Regex::is_valid('test&', Regex::DESCRIPTION));
    }
}
