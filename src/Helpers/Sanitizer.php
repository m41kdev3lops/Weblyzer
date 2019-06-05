<?php

namespace Weblyzer\Helpers;

class Sanitizer
{
    public static function sanitize( string $value )
    {
        $value = str_replace("/", "\\/", $value);
        $value = str_replace("\\", "\\\\", $value);
        $value = str_replace("\"", "\\\"", $value);
        $value = str_replace(".", "\\.", $value);
        $value = str_replace("?", "\\?", $value);
        $value = str_replace("(", "\\(", $value);
        $value = str_replace(")", "\\)", $value);

        return $value;
    }
}
