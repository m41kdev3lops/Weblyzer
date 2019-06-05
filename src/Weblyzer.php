<?php
namespace Weblyzer;

use Weblyzer\WeblyzerElement as Element;
use Weblyzer\Validators\Regex;
use Weblyzer\Helpers\Sanitizer;
use Weblyzer\Helpers\Logger;
use Weblyzer\Helpers\Finder;

class Weblyzer
{
    protected $html;
    protected $elements = [];


    public function __construct( string $html = '' )
    {
        $this->setHtml( $html );
    }


    public function setHtml( string $html )
    {
        $this->html = $html;

        return $this;
    }


    public function setElements( array $elements )
    {
        $this->elements = [];

        foreach ( $elements as $element ) {
            $this->elements[] = new Element( $element );
        }

        return $this;
    }


    public function getElements()
    {
        return $this->elements;
    }


    public function getElement()
    {
        if ( ! array_key_exists( 0, $this->elements ) ) throw new \Exception( "Element was not found!" );

        return $this->elements[0];
    }


    public function getHtml()
    {
        return $this->html;
    }


    public function findByClass( string $element, array $classNames )
    {
        $rules = implode(" ", $classNames);

        $pattern = "/(<\s*{$element}\s+(?:(?!class).)*class\s*=\s*[\"']\s*{$rules}\s*[\"'][^>]*>.*?<\s*\/\s*{$element}\s*>)/s";

        return Finder::find( $this, $pattern );
    }


    public function findByTag( string $element )
    {
        $pattern = "/(<\s*{$element}\s*[^>]*?>.*?<\s*\/\s*{$element}\s*>)/s";

        return Finder::find( $this, $pattern );
    }


    public function findByNonClosingTag( string $element )
    {
        $pattern = "/(<\s*{$element}\s*[^>]*\/?\s*>)/s";

        return Finder::find( $this, $pattern );
    }


    public function findById( string $element, string $id )
    {
        $pattern = "/(<\s*{$element}\s+(?:(?!id).)*id\s*=\s*[\"']\s*{$id}\s*[\"'][^>]*>.*?<\s*\/\s*{$element}\s*>)/s";

        return Finder::find( $this, $pattern );
    }


    public function findByAttribute( string $element, string $attribute, $value )
    {
        if ( is_array( $value ) ) $value = implode(" ", $value);

        $value = Sanitizer::sanitize( $value );

        $pattern = "/(<\s*{$element}\s+(?:(?!{$attribute}).)*{$attribute}\s*=\s*[\"']\s*{$value}\s*[\"'][^>]*>.*?<\s*\/\s*{$element}\s*>)/s";

        return Finder::find( $this, $pattern );
    }


    public function findByTagAfter( string $tag, string $after )
    {
        $after = Sanitizer::sanitize( $after );

        $pattern = "/{$after}[^<]*?(<\s*{$tag}.*?<\s*\/{$tag}[^>]*?>)/s";

        return Finder::find( $this, $after );
    }


    public function findByTagAfterRegex( string $tag, string $regex )
    {
        Regex::validate( $regex );

        preg_match( "/^(.)([^\\1]*?)\\1(.*?)$/", $regex, $matches );

        $delimeter = $matches[1];
        $regex = $matches[2];
        $flags = $matches[3];

        $final_flags = 's';

        if ( ! empty( $flags ) ) {
            $exploded_flags = str_split( $flags );
    
            foreach( $exploded_flags as $flag ) 
                if ( strpos( $final_flags,  $flag ) === false ) 
                    $final_flags .= $flag;
        }

        $pattern = "/{$regex}[^<]*?(<\s*{$tag}.*?<\s*\/{$tag}[^>]*?>)/{$final_flags}";

        return Finder::find( $this, $pattern );
    }


    public function findByTagBefore( string $tag, string $before )
    {
        $before = Sanitizer::sanitize( $before );

        $pattern = "/(<\s*{$tag}.*?<\s*\/{$tag}[^>]*?>).*?{$before}/s";

        return Finder::find( $this, $pattern );
    }
}
