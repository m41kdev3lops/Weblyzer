# Weblyzer
a very basic php web scrapper. UNDER DEVELOPMENT

# Example Usage
```php
$weblyzer = new Weblyzer\Weblyzer;

$data = $weblyzer->setUrl("URL-TO-SCRAPE")
    ->find("tag", [
        "class" => "class-name",
        "id"    => "class"
    ])
    ->getAll("child-tag");

// $data will contain a DOMNodeList object. Visit: https://www.php.net/manual/en/class.domnodelist.php to learn more.
```
