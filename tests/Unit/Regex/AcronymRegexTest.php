<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class AcronymRegexTest extends TestCase
{
    public function test_is_valid_acronym_length()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('TE', Regex::ACRONYM));
        $this->assertTrue(Regex::is_valid('TES', Regex::ACRONYM));

        // Fail
        $this->assertFalse(Regex::is_valid('TEEEST', Regex::ACRONYM));

        // Corner cases
        $this->assertFalse(Regex::is_valid('T', Regex::ACRONYM));
        $this->assertFalse(Regex::is_valid('TEEST', Regex::ACRONYM));
    }

    public function test_is_valid_acronym_characters()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('TE1', Regex::ACRONYM));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('tes', Regex::ACRONYM));
        $this->assertFalse(Regex::is_valid('TEs', Regex::ACRONYM));
        $this->assertFalse(Regex::is_valid('TE$', Regex::ACRONYM));
    }
}
