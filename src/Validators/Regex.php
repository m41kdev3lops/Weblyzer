<?php

namespace Weblyzer\Validators;

use Weblyzer\Interfaces\Validator;

class Regex implements Validator
{
    public static function validate( string $regex )
    {
        if ( preg_match( $regex, null ) === false )
            throw new \Exception( "{$regex} is not a valid Regular Expression!" );
        
        return True;
    }
}
