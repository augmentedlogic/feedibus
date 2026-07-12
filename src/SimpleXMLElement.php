<?php

namespace com\augmentedlogic\feedit;

/**
 * Class SimpleXMLElement
 */
class SimpleXMLElement extends \SimpleXMLElement
{
    /**
     * @param string $name
     * @param string $value
     * @param string $namespace
     * @return \SimpleXMLElement
     */
    public function addChild(string $name, ?string $value = null, ?string $namespace = null): ?static
    {
        if ($value !== null and is_string($value) === true) {
            $value = str_replace('&', '&amp;', $value);
        }

        return parent::addChild($name, $value, $namespace);
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $namespace
     * @return \SimpleXMLElement
     */
    public function addCdataChild(string $name, ?string $value = null, ?string $namespace = null): ?static
    {
        $element = $this->addChild($name, null, $namespace);
        $dom = dom_import_simplexml($element);
        $elementOwner = $dom->ownerDocument;
        $dom->appendChild($elementOwner->createCDATASection($value));
        return $element;
    }
}
