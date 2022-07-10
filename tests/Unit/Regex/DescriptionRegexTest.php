<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class DescriptionRegexTest extends TestCase
{
    public function test_is_valid_description_length()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('testtest', Regex::DESCRIPTION_TEXT));

        // Fail
        $this->assertFalse(Regex::is_valid('', Regex::DESCRIPTION_TEXT));

        // Corner cases
        $this->assertTrue(Regex::is_valid('t', Regex::DESCRIPTION_TEXT));
        $this->assertFalse(Regex::is_valid('', Regex::DESCRIPTION_TEXT));
    }

    public function test_is_valid_description_characters()
    {
        // Pass & Corner cases
        $this->assertTrue(Regex::is_valid('testtest', Regex::DESCRIPTION_TEXT));
        $this->assertTrue(Regex::is_valid('Testtest', Regex::DESCRIPTION_TEXT));
        $this->assertTrue(Regex::is_valid('Testtest1', Regex::DESCRIPTION_TEXT));
        $this->assertTrue(Regex::is_valid(' .,-_:()/!?', Regex::DESCRIPTION_TEXT));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('test$', Regex::DESCRIPTION_TEXT));
        $this->assertFalse(Regex::is_valid('test%', Regex::DESCRIPTION_TEXT));
        $this->assertFalse(Regex::is_valid('test&', Regex::DESCRIPTION_TEXT));
    }
}
