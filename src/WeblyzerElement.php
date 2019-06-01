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


    public function getHtml()
    {
        return $this->html;
    }


    public function getText()
    {
        $pattern = "/<\s*(\w+)[^>]*>(.*?)<\/\s*\\1\s*>/";

        preg_match( $pattern, $this->html, $matches );

        if ( ! array_key_exists( 2, $matches ) || empty( $matches[2] ) ) throw new \Exception( "Unable to retrieve text" );

        return $matches[2];
    }


    public function getAttribute( string $attribute )
    {
        $pattern = "/{$attribute}\s*=(['|\"])([^>]*?)\\1/i";

        preg_match( $pattern, $this->html, $matches );

        if ( ! array_key_exists( 2, $matches ) || empty( $matches[2] ) ) throw new \Exception( "Failed to get attribute => {$attribute}" );

        return $matches[2];
    }
}
