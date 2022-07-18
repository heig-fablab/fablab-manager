<?php

namespace App\Constants;

use Illuminate\Support\Facades\Log;

final class Regex
{
    // Refs mime types:
    // https://stackoverflow.com/questions/25201083/regex-to-match-and-validate-internet-media-type
    // https://www.rfc-editor.org/rfc/rfc2425.html

    public const ACRONYM = '/^[A-Z0-9]{2,4}$/';
    public const DESCRIPTION_TEXT = '/^[\w .,\-_:()\/\?\!]{1,65535}$/';
    public const FILE_TYPE_NAME = '/^[a-z0-9]{2,10}$/';
    public const JOB_CATEGORY_NAME = '/^[\w .,\-_:()\/]{3,50}$/';
    public const MIME_TYPE = '/^\w+\/[\-.\w]+$/';
    public const NAME = '/^[\w\- ]{3,50}$/';
    public const ROLE_NAME = '/^[a-z]{3,12}$/';
    public const USERNAME = '/^[a-z]{2,7}[a-z0-9]?\.[a-z]{2,8}$/';
    public const TITLE = '/^[\w \-_\/]{2,50}$/';

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

    public static function is_valid(string $input, string $regex): bool
    {
        return preg_match($regex, $input);
    }
}
