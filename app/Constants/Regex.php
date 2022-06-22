<?php

namespace App\Constants;

use Illuminate\Support\Facades\Log;

final class Regex
{
    public const DESCRIPTION = '/^[\w .,-_:()\\/]{4,65535}$/';
    public const TITLE = '/^[\w -_\\/]{3,50}$/';
    public const SWITCH_UUID = '/^.*$/'; // TODO //[0-9a-zA-Z]{3,}@(hes-so|heig-vd).ch
    public const NAME = '/^[\w -_]{3,50}$/';
    public const ROLE_NAME = '/^[a-z]{3,12}$/';
    public const ACRONYM = '/^[A-Z0-9]{2,3}$/';
    public const JOB_CATEGORY_NAME = '/^[\w .,-_:()\\/]{3,50}$/';
    public const DEVICE_NAME = '/^[\w .,-_:()\\/]{3,50}$/';
    public const FILE_TYPE_NAME = '/^[a-z0-9]{2,10}$/';
    public const MIME_TYPE = '/^\w+\/[-.\w]+$/';
    //src: https://stackoverflow.com/questions/25201083/regex-to-match-and-validate-internet-media-type

    // TODO: perhaps creates a rule
    private const PASSWORD_UPPER_CASE = '/[A-Z]/';
    private const PASSWORD_LOWER_CASE = '/[a-z]/';
    private const PASSWORD_DIGIT = '/[0-9]/';
    private const PASSWORD_SPECIAL_CHAR = '/[#?!@$ %^&*-]/';
    private const PASSWORD_GLOBAL = '/^.{8,64}$/';

    public static function is_valid_password(string $password): bool
    {
        Log::debug('Password regex match');
        Log::debug('upper case: ' . preg_match(self::PASSWORD_UPPER_CASE, $password));
        Log::debug('lower case: ' . preg_match(self::PASSWORD_LOWER_CASE, $password));
        Log::debug('digit: ' . preg_match(self::PASSWORD_DIGIT, $password));
        Log::debug('special char: ' . preg_match(self::PASSWORD_SPECIAL_CHAR, $password));
        Log::debug('length: ' . preg_match(self::PASSWORD_GLOBAL, $password));

        return preg_match(self::PASSWORD_UPPER_CASE, $password)
            && preg_match(self::PASSWORD_LOWER_CASE, $password)
            && preg_match(self::PASSWORD_DIGIT, $password)
            && preg_match(self::PASSWORD_SPECIAL_CHAR, $password)
            && preg_match(self::PASSWORD_GLOBAL, $password);
    }
}
