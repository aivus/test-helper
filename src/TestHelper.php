<?php
namespace Aivus\TestHelper;

use ReflectionClass;
use ReflectionMethod;

class TestHelper
{
    /**
     * This method allows to get property value of class (if property is static) or object (include private/protected)
     *
     * @param string|object $classNameOrObject
     * @param               $propertyName
     *
     * @return mixed
     */
    public function getPropertyValue($classNameOrObject, $propertyName)
    {
        $property = $this->getProperty($classNameOrObject, $propertyName);
        if (is_object($classNameOrObject)) {
            $value = $property->getValue($classNameOrObject);
        } elseif (class_exists($classNameOrObject) && $property->isStatic()) {
            $value = $property->getValue();
        } else {
            throw new \InvalidArgumentException('Property not found in object or class name passed with non-static property');
        }

        return $value;
    }

    /**
     * This method allows to set value of class (if property is static) or object property
     *
     * @param string|object $classNameOrObject
     * @param string        $propertyName
     * @param mixed         $propertyValue
     */
    public function setPropertyValue($classNameOrObject, $propertyName, $propertyValue)
    {
        $property = $this->getProperty($classNameOrObject, $propertyName);
        if (is_object($classNameOrObject)) {
            $property->setValue($classNameOrObject, $propertyValue);
        } elseif (is_string($classNameOrObject) && class_exists($classNameOrObject) && $property->isStatic()) {
            $property->setValue($propertyValue);
        } else {
            throw new \InvalidArgumentException('Property not found in object or class name passed with non-static property');
        }
    }

    /**
     * This method allows to get class method (include private/protected)
     *
     * @param     object|string $classNameOrObject Object or class name
     * @param     string        $methodName
     *
     * @return    ReflectionMethod
     */
    public function getMethod($classNameOrObject, $methodName)
    {
        $reflector = new ReflectionClass($classNameOrObject);
        $method    = $reflector->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * This method allows to get class property (include private/protected)
     *
     * @param string|object $classNameOrObject
     * @param string        $propertyName
     *
     * @return \ReflectionProperty
     */
    public function getProperty($classNameOrObject, $propertyName)
    {
        $reflector = new ReflectionClass($classNameOrObject);
        $property  = $reflector->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }

    /**
     * This method provide ability to call private/protected methods in the object
     *
     * @param string|object $classNameOrObject
     * @param string        $methodName
     * @param array         $parameters
     *
     * @return mixed
     */
    public function invokeMethod($classNameOrObject, $methodName, $parameters = array())
    {
        $methodReflection = $this->getMethod($classNameOrObject, $methodName);

        // If string passed and class exist - try to create instance for call method
        // This allow to invoke static methods
        if (is_string($classNameOrObject) && class_exists($classNameOrObject)) {
            // TODO: Throw exception when try to create abstract class
            $classNameOrObject = new $classNameOrObject;
        }
        return $methodReflection->invokeArgs($classNameOrObject, $parameters);
    }
}
