<?php

namespace Weblyzer\Helpers;

class Logger
{
    public static function log( string $msg, string $file = "weblyzer_debug.txt" )
    {
        if ( file_put_contents( $file, $msg, FILE_APPEND ) === false )
            throw new \Exception( "Logging failed!" );
        
        return True;
    }
}
