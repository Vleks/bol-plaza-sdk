<?php
namespace Vleks\BolPlazaSDK\Enumerables;

abstract class Enumerable
{
    /**
     * Return all available constants in the enumerable object
     *
     * @return  array
     */
    public static function getAll()
    {
        $calledClass     = get_called_class();
        $reflectionClass = new \ReflectionClass($calledClass);
        return $reflectionClass->getConstants();
    }

    /**
     * Checks whether a provided value exists in the enumerable object
     *
     * @param   string  $key
     * @return  bool
     */
    public static function has($key)
    {
        return array_key_exists($key, static::getAll());
    }
}
