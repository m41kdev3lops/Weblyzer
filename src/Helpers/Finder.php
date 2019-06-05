<?php

namespace Weblyzer\Helpers;

use Weblyzer\Weblyzer;
use Weblyzer\Validators\Regex;

class Finder
{
    public static function find( Weblyzer $weblyzer, string $pattern, int $index = 1 )
    {
        Regex::validate( $pattern );

        preg_match_all( $pattern, $weblyzer->getHtml(), $matches );

        if ( ! array_key_exists( $index, $matches ) || empty( $matches[$index] ) ) {
            Logger::log( "The pattern {$pattern} did NOT match anything => \n\n HTML => \n{$weblyzer->getHtml()} \n\n Regex =. $pattern \n\n========================\n\n" );
            throw new \Exception( "The pattern {$pattern} did NOT match anything" );
        }

        $html = '';

        if ( is_array( $matches[$index] ) ) {
            $weblyzer->setElements( $matches[$index] );

            foreach( $matches[$index] as $match ) {
                $html .= $match;
            }
        } else {
            $html = $matches[$index];
        }

        $weblyzer->setHtml( $html );

        return $weblyzer;
    }
}
