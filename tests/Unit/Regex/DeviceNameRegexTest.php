<?php

namespace Tests\Unit\Regex;

use Tests\TestCase;
use App\Constants\Regex;

class DeviceNameRegexTest extends TestCase
{
    public function test_is_valid_device_name_length()
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

    public function test_is_valid_device_name_characters()
    {
        // Pass & Corner cases
        $this->assertTrue(Regex::is_valid('testtest', Regex::DEVICE_NAME));
        $this->assertTrue(Regex::is_valid('Testtest', Regex::DEVICE_NAME));
        $this->assertTrue(Regex::is_valid('Testtest1', Regex::DEVICE_NAME));
        $this->assertTrue(Regex::is_valid(' .,-_:()\/', Regex::DEVICE_NAME));

        // Fail & Corner cases
        $this->assertFalse(Regex::is_valid('test$', Regex::DEVICE_NAME));
        $this->assertFalse(Regex::is_valid('test%', Regex::DEVICE_NAME));
        $this->assertFalse(Regex::is_valid('test&', Regex::DEVICE_NAME));
    }
}
