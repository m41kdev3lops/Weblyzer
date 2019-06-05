<?php

namespace Weblyzer\Helpers;

class Regex
{
    public static function extract( string $regex, string $final_flags = 'is' )
    {
        preg_match( "/^(.)([^\\1]*?)\\1(.*?)$/", $regex, $matches );

        $delimeter = $matches[1];
        $regex = $matches[2];
        $flags = $matches[3];

        if ( ! empty( $flags ) ) {
            $exploded_flags = str_split( $flags );
    
            foreach( $exploded_flags as $flag ) 
                if ( strpos( $final_flags,  $flag ) === false ) 
                    $final_flags .= $flag;
        }

        return [
            "delimeter"     => $delimeter,
            "regex"         => $regex,
            "final_flags"   => $final_flags,
            "flags"         => $flag
        ];
    }
}
