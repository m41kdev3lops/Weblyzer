<?php
namespace Weblyzer;

use Curler\Curler;

/**
 * Weblyzer main class.
 */
class Weblyzer
{
    protected $curler;
    protected $url;
    protected $method;
    protected $html;
    protected $dom;

    protected $availableRules = [
        "class", "id"
    ];


    public function __construct()
    {
        $this->curler = new Curler;
        $this->dom = new \DOMDocument;
    }


    public function setUrl( string $url, string $method = 'get' )
    {
        $this->url = $url;
        $this->method = $method;

        $this->setHtml( $this->curler->{$method}( $url ) );

        return $this;
    }


    public function setHtml( string $html )
    {
        $this->html = $html;
        @$this->dom->loadHtml(  $html );

        return $this;
    }


    public function getHtml()
    {
        return $this->html;
    }


    public function find( string $element, array $rules = [] )
    {
        foreach( $rules as $rule => $value ) if ( ! in_array( $rule, $this->availableRules ) ) throw new \Exception("The rule => {$rule} => isn't allowed.");

        $rules = [
            "element"   => $element,
            "rules"     => $rules
        ];
        
        $html = $this->getByRules( $rules );
        
        if ( empty( $html ) || ! $html ) throw new \Exception("We couldn't find any {$element}s with the rules you gave");

        $this->setHtml( $html );

        return $this;
    }


    public function getAll( string $element )
    {
        return $this->dom->getElementsByTagName( $element );
    }


    private function getByRules( array $rules )
    {
        if ( ! array_key_exists( 'element', $rules ) || ! array_key_exists( 'rules', $rules ) ) throw new \Exception( "element OR rules key doesn't exist in the rules you gave me!" );

        $element = $rules['element'];
        $rules = $rules['rules'];
        $given_rules = [];
        $rule = '';

        if ( ! empty( $rules ) ) {
            foreach( $rules as $rule => $value ) $given_rules[] = "{$rule}\\s*=\\s*['\"]\\s*{$value}\\s*['\"]";
    
            if ( ! empty( $given_rules ) ) $rule = "\\s*" . implode("\\s+\\w*", $given_rules);
        }

        $pattern = "/(<\s*{$element}{$rule}\s*>.*?<\s*\/{$element}\s*>)/";


        preg_match( $pattern, $this->html, $matches );
        
        if ( empty( $matches ) ) return [];

        return $matches[0];
    }
}
