<?php
namespace Vleks\BolPlazaSDK;

use Vleks\BolPlazaSDK\Exceptions;

abstract class Entity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $fields = array();

    /**
     * Construct a new entity
     *
     * @param   array   $data
     * @throws  Vleks\BolPlazaSDK\Exceptions\EntityException
     */
    public function __construct($data = null)
    {
        if (!is_null($data)) {
            if ($this->isAssociativeArray($data)) {
                $this->fromAssociativeArray($data);
            } elseif ($this->isDOMElement($data)) {
                $this->fromDOMElement($data);
            } else {
                throw new Exceptions\EntityException('Unable to construct from provided data.');
            }
        }
    }

    /**
     * Returns the requested entity value
     *
     * @param   string  $property
     * @return  mixed
     * @throws  Vleks\BolPlazaSDK\Exceptions\EntityException
     */
    public function get($property)
    {
        if ($this->propertyExists($property)) {
            return $this->fields[$property]['value'];
        }

        throw new Exceptions\EntityException(sprintf('Property "%s" does not exist.', $property));
    }

    /**
     * Returns the requested entity value parameter
     *
     * @param   string  $property
     * @param   string  $parameter
     * @return  mixed
     * @throws  Vleks\BolPlazaSDK\Exceptions\EntityException
     */
    public function getParameter($property, $parameter)
    {
        if ($this->propertyExists($property)) {
            $property = $this->fields[$property];

            if (isset($property['parameters'][$parameter])) {
                return $property['parameters'][$parameter]['value'];
            }

            throw new Exceptions\EntityException(sprintf('Property parameter "%s" does not exist.', $parameter));
        }

        throw new Exceptions\EntityException(sprintf('Property "%s" does not exist.', $property));
    }

    /**
     * Sets a entity value
     *
     * @param   string  $property
     * @param   string  $value
     * @return  Vleks\BolPlazaSDK\Entities\Entity
     * @throws  Vleks\BolPlazaSDK\Exceptions\EntityException
     */
    public function set($property, $value)
    {
        if ($this->propertyExists($property)) {
            $this->fields[$property]['value'] = $value;
            return $this;
        }

        throw new Exceptions\EntityException(sprintf('Property "%s" does not exist.', $property));
    }

    /**
     * Removes a value from the entity
     *
     * @param   string  $property
     * @return  Vleks\BolPlazaSDK\Entities\Entity
     * @throws  Vleks\BolPlazaSDK\Exceptions\EntityException
     */
    public function remove($property)
    {
        if (!$this->propertyExists($property)) {
            throw new Exceptions\EntityException(sprintf('Property "%s" does not exist.', $property));
        }

        $this->fields[$property]['value'] = NULL;
        return $this;
    }

    /**
     * Determines if a property exists in the field list
     *
     * @param   string  $property
     * @return  bool
     */
    public function propertyExists($property)
    {
        return array_key_exists($property, $this->fields);
    }

    /**
     * Determines if the entity has a value
     *
     * @param   string  $property
     * @return  bool
     * @throws  Vleks\BolPlazaSDK\Exceptions\EntityException
     */
    public function has($property)
    {
        if (!$this->propertyExists($property)) {
            throw new Exceptions\EntityException(sprintf('Property "%s" does not exist.', $property));
        }

        if ($this->isNumericArray($this->fields[$property]['value'])) {
            return !empty($this->fields[$property]['value']);
        }

        return !is_null($this->fields[$property]['value']);
    }

    /**
     * Create a XML fragment
     *
     * @return  string
     */
    protected function toXMLFragment()
    {
        $xml = '';

        foreach ($this->fields as $name => $field) {
            $value = $field['value'];
            $type  = $field['type'];

            if (!is_null($value)) {
                if (is_array($type)) {
                    $key = key($type);

                    if ($this->isComplexType($type[$key])) {
                        if (!is_numeric($key)) {
                            $subxml = '';

                            foreach ($value as $item) {
                                $subxml .= sprintf('<%1$s%3$s>%2$s</%1$s>', $key, $item->toXMLFragment(), $item->getAttributes());
                            }

                            if (!empty($subxml)) {
                                $xml .= sprintf('<%1$s>%2$s</%1$s>', $name, $subxml);
                            }
                        } else {
                            foreach ($value as $item) {
                                $xml .= sprintf('<%1$s%3$s>%2$s</%1$s>', $name, $item->toXMLFragment(), $item->getAttributes());
                            }
                        }
                    } elseif ('@' != substr($type[$key], 0, 1)) {
                        foreach ($value as $item) {
                            switch ($type[$key]) {
                                case 'DateTime':
                                    $item = $item->format(\DateTime::ATOM);
                                    break;
                                case 'bool':
                                    $item = $item ? 'true' : 'false';
                                    break;
                                case 'float':
                                    $item = number_format($item, 2, '.', '');
                                    break;
                            }

                            $xml .= sprintf('<%1$s>%2$s</%1$s>', $name, $this->escapeXML($item));
                        }
                    }
                } else {
                    if ($this->isComplexType($type)) {
                        $xml .= sprintf('<%1$s%3$s>%2$s</%1%s>', $name, $value->toXMLFragment(), $value->getAttributes());
                    } elseif ('@' != substr($type, 0, 1)) {
                        switch ($type) {
                            case 'DateTime':
                                $value = $value->format(\DateTime::ATOM);
                                break;
                            case 'bool':
                                $value = $value ? 'true' : 'false';
                                break;
                            case 'float':
                                $value = number_format($value, 2, '.', '');
                                break;
                        }

                        $xml .= sprintf('<%1$s>%2$s</%1$s>', $name, $this->escapeXML($value));
                    }
                }
            }
        }

        return $xml;
    }

    /**
     * Get attributes
     *
     * @return  string
     */
    protected function getAttributes()
    {
        $xml = '';

        foreach ($this->fields as $name => $field) {
            $value = $field['value'];
            $type  = $field['type'];

            if (!is_null($value) && '@' == $type[0]) {
                switch (ltrim($type, '@')) {
                    case 'DateTime':
                        $value = $value->format(\DateTime::ATOM);
                        break;
                    case 'bool':
                        $value = $value ? 'true' : 'false';
                        break;
                    case 'float':
                        $value = number_format($value, 2, '.', '');
                        break;
                }

                $xml .= sprintf(' %s="%s"', $name, $this->escapeXML($value));
            }
        }

        return $xml;
    }

    /**
     * Escape XML string
     *
     * @param   string  $str
     * @return  string
     */
    private function escapeXML($str)
    {
        $from = array('&', '<', '>', '\'', '"');
        $to   = array('&amp;', '&lt;', '&gt;', '&#039;', '&quot;');

        return str_replace($from, $to, $str);
    }

    /**
     * Construct from DOMElement
     *
     * @param   DOMElement  $dom
     */
    private function fromDOMElement(\DOMElement $dom)
    {
        $xpath     = new \DOMXPath($dom->ownerDocument);
        $prefix    = '';
        $namepaces = $xpath->query('namespace::*', $dom);

        if (1 < $namepaces->length) {
            foreach ($namepaces as $namepace) {
                $arbitrary       = 'xs';
                $namespacePrefix = empty($namepace->prefix) ? $arbitrary : $namepace->prefix;

                if ('xmlns:xml' === $namepace->nodeName && empty($prefix)) {
                    $namespacePrefix = $arbitrary;
                    $prefix          = 'xs:';
                }

                $namespaceUri    = $namepace->nodeValue;

                $xpath->registerNamespace($namespacePrefix, $namespaceUri);            }
        }

        foreach ($this->fields as $name => $field) {
            $type = $field['type'];

            if (isset($field['ns'])) {
                $prefix = $field['ns'];
            }

            if (is_array($type)) {
                $key = key($type);
                $src = $name;

                if ($this->isComplexType($type[$key])) {
                    if (!is_numeric($key)) {
                        $src .= '/' . $prefix . $key;
                    }

                    $elements = $xpath->query('./' . $prefix . $src, $dom);

                    if (1 <= $elements->length) {
                        foreach ($elements as $element) {
                            $this->fields[$name]['value'][] = new $type[$key]($element);
                        }
                    }
                } else {
                    $elements = $xpath->query('./' . $prefix . $name, $dom);

                    if (1 <= $elements->length) {
                        foreach ($elements as $element) {
                            $text = $xpath->query('./' . $prefix . 'text()', $element);
                            $data = null;

                            switch (ltrim($type[$key], '@')) {
                                case 'DateTime':
                                    $data = new \DateTime($text->item(0)->data, new \DateTimeZone(date_default_timezone_get()));
                                    break;
                                case 'bool':
                                    $data = filter_var($text->item(0)->data, FILTER_VALIDATE_BOOLEAN);
                                    break;
                                case 'int':
                                    $data = (int)$text->item(0)->data;
                                    break;
                                case 'float':
                                    $data = number_format((float)$text->item(0)->data, 2);
                                    break;
                                default:
                                    $data = $text->item(0)->data;
                                    break;
                            }

                            $this->fields[$name]['value'][] = $data;
                        }
                    }
                }
            } else {
                if ($this->isComplexType($type)) {
                    $elements = $xpath->query('./' . $prefix . $name, $dom);

                    if (1 === $elements->length) {
                        $this->fields[$name]['value'] = new $type($elements->item(0));
                    }
                } else {
                    $element = $xpath->query('./' . $prefix . $name . '/text()', $dom);
                    $data    = null;

                    if (1 === $element->length) {
                        switch (ltrim($type, '@')) {
                            case 'DateTime':
                                $data = new \DateTime($element->item(0)->data, new \DateTimeZone(date_default_timezone_get()));
                                break;
                            case 'bool':
                                $data = filter_var($element->item(0)->data, FILTER_VALIDATE_BOOLEAN);
                                break;
                            case 'int':
                                $data = (int)$element->item(0)->data;
                                break;
                            case 'float':
                                $data = number_format((float)$element->item(0)->data, 2);
                                break;
                            default:
                                $data = $element->item(0)->data;
                                break;
                        }

                        $this->fields[$name]['value'] = $data;

                        if (!empty($field['parameters'])) {
                            foreach ($field['parameters'] as $parameterName => $parameterField) {
                                $parameter     = $xpath->query('./' . $prefix . $name . '/@' . $parameterName, $dom);
                                $parameterData = null;

                                if (1 === $parameter->length) {
                                    switch (ltrim($parameterField['type'], '@')) {
                                        case 'DateTime':
                                            $parameterData = new \DateTime($parameter->item(0)->value, new \DateTimeZone(date_default_timezone_get()));
                                            break;
                                        case 'bool':
                                            $parameterData = filter_var($parameter->item(0)->value, FILTER_VALIDATE_BOOLEAN);
                                            break;
                                        case 'int':
                                            $parameterData = (int)$parameter->item(0)->value;
                                            break;
                                        case 'float':
                                            $parameterData = number_format((float)$parameter->item(0)->value, 2);
                                            break;
                                        default:
                                            $parameterData = $parameter->item(0)->value;
                                            break;
                                    }
                                }

                                $this->fields[$name]['parameters'][$parameterName]['value'] = $parameterData;
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Construct from associative array
     *
     * @param   array   $array
     */
    private function fromAssociativeArray($array)
    {
        foreach ($this->fields as $name => $field) {
            $type = $field['type'];

            if (is_array($type)) {
                $key = key($type);

                if ($this->isComplexType($type[$key])) {
                   if (array_key_exists($name, $array)) {
                       $elements = $array[$name];

                       if (!$this->isNumericArray($elements)) {
                           $elements = array($elements);
                       }

                       if (1 <= count($elements)) {
                           foreach ($elements as $element) {
                               $this->fields[$name]['value'][] = new $type[$key]($element);
                           }
                       }
                   }
                } else {
                    if (array_key_exists($name, $array)) {
                        $elements = $array[$name];

                        if (!$this->isNumericArray($elements)) {
                            $elements = array($elements);
                        }

                        if (1 <= count($elements)) {
                            foreach ($elements as $element) {
                                $this->fields[$name]['value'] = $element;
                            }
                        }
                    }
                }
            } else {
                if ($this->isComplexType($type)) {
                    if (array_key_exists($name, $array)) {
                        $this->fields[$name]['value'] = new $type($array[$name]);
                    }
                } else {
                    if (array_key_exists($name, $array)) {
                        $this->fields[$name]['value'] = $array[$name];
                    }
                }
            }
        }
    }

    /**
     * Create an entity from an associative array
     *
     * @param   array   $array
     * @return  Vleks\BolPlazaSDK\Entities\Entity
     * @throws  Vleks\BolPlazaSDK\Exceptions\EntityException
     */
    public static function createFromArray($array)
    {
        $class  = get_called_class();
        return new $class($array);
    }

    /**
     * Create a entity from XML
     *
     * @param   string  $xml
     * @return  Vleks\BolPlazaSDK\Entities\Entity
     * @throws  Vleks\BolPlazaSDK\Exceptions\EntityException
     */
    public static function createFromXML($xml)
    {
        $dom = new \DOMDocument;
        $dom->recover = true;
        $dom->formatOutput = true;

        if ($dom->loadXML($xml)) {

            $xpath = new \DOMXPath($dom);

            if (!empty($dom->documentElement->namespaceURI)) {
                $prefix       = !empty($dom->documentElement->prefix) ? '' : 'xs:';
                $namespace    = !empty($dom->documentElement->prefix) ? $dom->documentElement->prefix : 'xs';
                $namespaceUri = $dom->documentElement->namespaceURI;

                $xpath->registerNameSpace($namespace, $namespaceUri);

                $response = $xpath->query('//' . $prefix . $dom->documentElement->nodeName)->item(0);
            } else {
                $response = $xpath->query('.')->item(0);
            }

            return new static($response);
        }

        throw new Exceptions\EntityException();
    }

    /**
     * Get XML
     *
     * @return  string
     * @throws  Vleks\BolPlazaSDK\Exceptions\EntityException
     */
    public function getXML()
    {
        if (empty($this->name))
            throw new Exceptions\EntityException('Cannot create XML from this entity.');

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<' . $this->name . ' xmlns="https://plazaapi.bol.com/services/xsd/v1/plazaapi.xsd">';
        $xml .= $this->toXMLFragment();
        $xml .= '</' . $this->name . '>';

        return $xml;
    }

    /**
     * Determines if the passed variable is an associative array
     *
     * @param   mixed   $var
     * @return  bool
     */
    private function isAssociativeArray($var)
    {
        return is_array($var) && array_keys($var) !== range(0, count($var) - 1);
    }

    /**
     * Determines if the passed variable is a numeric array
     *
     * @param   mixed   $var
     * @return  bool
     */
    private function isNumericArray($var)
    {
        return is_array($var) && (empty($var) || array_keys($var) === range(0, count($var) - 1));
    }

    /**
     * Determines if the passed variable is a DOMElement instance
     *
     * @param   mixed   $var
     * @return  bool
     */
    private function isDOMElement($var)
    {
        return $var instanceof \DOMElement;
    }

    /**
     * Determines if the passed variable represents a complex type
     *
     * @param   mixed   $var
     * @return  bool
     */
    private function isComplexType($var)
    {
        return preg_match('/^Vleks\\\\BolPlazaSDK\\\\/', $var);
    }
}
