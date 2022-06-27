<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class JobCategoryNameRegexTest extends TestCase
{
    public function test_is_valid_job_category_name_length()
    {
        // Pass
        $this->assertTrue(Regex::is_valid('testtest', Regex::DEVICE_NAME));

        // Fail
        $this->assertFalse(Regex::is_valid('t', Regex::DEVICE_NAME));
        $this->assertFalse(Regex::is_valid('teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest', Regex::DEVICE_NAME)); // 55

        // Corner cases
        $this->assertTrue(Regex::is_valid('tes', Regex::DEVICE_NAME));
        $this->assertFalse(Regex::is_valid('te', Regex::DEVICE_NAME));

        $this->assertTrue(Regex::is_valid('teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest', Regex::DEVICE_NAME)); // 50
        $this->assertFalse(Regex::is_valid('teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeest', Regex::DEVICE_NAME)); // 51
    }

    public function test_is_valid_job_category_name_characters()
    {
        // Pass & Corner cases
        $this->assertTrue(Regex::is_valid('testtest', Regex::JOB_CATEGORY_NAME));
        $this->assertTrue(Regex::is_valid('Testtest', Regex::JOB_CATEGORY_NAME));
        $this->assertTrue(Regex::is_valid('Testtest1', Regex::JOB_CATEGORY_NAME));
        $this->assertTrue(Regex::is_valid(' .,-_:()\/', Regex::JOB_CATEGORY_NAME));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('test$', Regex::JOB_CATEGORY_NAME));
        $this->assertFalse(Regex::is_valid('test%', Regex::JOB_CATEGORY_NAME));
        $this->assertFalse(Regex::is_valid('test&', Regex::JOB_CATEGORY_NAME));
    }
}
