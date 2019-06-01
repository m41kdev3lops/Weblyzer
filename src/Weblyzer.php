<?php
namespace Weblyzer;

use Weblyzer\WeblyzerElement as Element;


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


    private function setElements( array $elements )
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

        $pattern = "/<\s*{$element}\s+(?:(?!class).)*class\s*=\s*[\"']\s*{$rules}\s*[\"'][^>]*>(.*?)<\s*\/\s*{$element}\s*>/s";

        return $this->matchOrDie( $element, $pattern );
    }


    public function findByTag( string $element )
    {
        $pattern = "/<\s*{$element}[^>]*>(.*?)<\s*\/\s*{$element}\s*>/s";

        return $this->matchOrDie( $element, $pattern );
    }


    public function findById( string $element, string $id )
    {
        $pattern = "/<\s*{$element}\s+(?:(?!id).)*id\s*=\s*[\"']\s*{$id}\s*[\"'][^>]*>(.*?)<\s*\/\s*{$element}\s*>/s";

        return $this->matchOrDie( $element, $pattern );
    }


    public function findByAttribute( string $element, string $attribute, $value )
    {
        if ( is_array( $value ) ) $value = implode(" ", $value);

        $value = $this->sanitize( $value );

        $pattern = "/<\s*{$element}\s+(?:(?!{$attribute}).)*{$attribute}\s*=\s*[\"']\s*{$value}\s*[\"'][^>]*>(.*?)<\s*\/\s*{$element}\s*>/s";

        return $this->matchOrDie( $element, $pattern );
    }

    
    private function sanitize( string $value )
    {
        return str_replace("/", "\\/", $value);
    }


    private function matchOrDie( string $element, string $pattern )
    {
        preg_match_all( $pattern, $this->html, $matches );

        if ( ! array_key_exists( 1, $matches ) || empty( $matches[1] ) ) throw new \Exception( "Tag {$element} was not found!!" );

        $html = '';

        if ( is_array( $matches[1] ) ) {
            $this->setElements( $matches[1] );

            foreach( $matches[1] as $match ) {
                $html .= $match;
            }
        } else {
            $html = $matches[1];
        }

        $this->setHtml( $html );

        return $this;
    }
}
