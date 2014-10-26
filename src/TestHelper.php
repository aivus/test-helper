<?php
namespace aivus\TestHelper;

use ReflectionClass;
use ReflectionMethod;

class TestHelper
{
    /**
     * The method allows get property value of class or object (include private/protected)
     *
     * @param $classOrObject
     * @param $propertyName
     * @return mixed
     */
    public static function getPrivatePropertyValue($classOrObject, $propertyName)
    {
        $reflector = new ReflectionClass($classOrObject);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);
        if (is_object($classOrObject)) {
            $value = $property->getValue($classOrObject);
        } else {
            $value = $property->getValue();
        }

        return $value;
    }

    /**
     * The method allows get class methods (include private/protected)
     *
     * @author    Joe Sexton <joe@webtipblog.com>
     * @param     string $className
     * @param     string $methodName
     * @return    ReflectionMethod
     */
    public static function getPrivateMethod($className, $methodName)
    {
        $reflector = new ReflectionClass($className);
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * The method allows set value of private/protected property
     *
     * @param string|object $classOrObject
     * @param string $propertyName
     * @param mixed $propertyValue
     */
    public static function setPrivateProperty($classOrObject, $propertyName, $propertyValue)
    {
        $reflector = new ReflectionClass($classOrObject);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);
        if (is_object($classOrObject)) {
            $property->setValue($classOrObject, $propertyValue);
        } else {
            $property->setValue($propertyValue);
        }
    }
} 