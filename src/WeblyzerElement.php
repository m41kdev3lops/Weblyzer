<?php

namespace Weblyzer;


class WeblyzerElement
{
    protected $html = null;

    public function __construct( string $html )
    {
        $this->setHtml( $html );
    }


    public function setHtml( string $html )
    {
        $this->html = $html;

        return $this;
    }


    public function getText()
    {
        $pattern = "/<\s*\w+\s*[^>]*>(.*?)<\/\s*\w+\s*>/";

        preg_match( $pattern, $this->html, $matches );

        if ( ! array_key_exists( 1, $matches ) || empty( $matches[1] ) ) throw new \Exception( "Unable to retrieve text" );

        return $matches[1];
    }


    public function getAttribute( string $attribute )
    {
        $pattern = "/<\s*\b\s*[^>]*\s*{$attribute}\s*=['|\"](\s*[^>]*)['|\"]>(.*?)<\/\s*\w+\s*>/";

        preg_match( $pattern, $this->html, $matches );

        if ( ! array_key_exists( 1, $matches ) || empty( $matches[1] ) ) throw new \Exception( "Failed to get attribute => {$attribute}" );

        return $matches[1];
    }
}
