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

        // Corner cases
    }

    public function test_is_valid_acronym_characters()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('TES', Regex::ACRONYM));

        // Fail & Corner cases
    }
}
