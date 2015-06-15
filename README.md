Test Helper
===========

[![Build Status](https://travis-ci.org/aivus/test-helper.svg?branch=master)](https://travis-ci.org/aivus/test-helper)
[![Coverage Status](https://coveralls.io/repos/aivus/test-helper/badge.svg)](https://coveralls.io/r/aivus/test-helper)
[![Latest Stable Version](https://poser.pugx.org/aivus/test-helper/v/stable.svg)](https://packagist.org/packages/aivus/test-helper)
[![Total Downloads](https://poser.pugx.org/aivus/test-helper/downloads.svg)](https://packagist.org/packages/aivus/test-helper)
[![Latest Unstable Version](https://poser.pugx.org/aivus/test-helper/v/unstable.svg)](https://packagist.org/packages/aivus/test-helper) 

This package provide simple helpers for testing.

API
===

### TestHelper::getPropertyValue($classOrObject, $propertyName)

This method allows to get property value of class (if property is static) or object (include private/protected)

### TestHelper::setPropertyValue($classOrObject, $propertyName, $propertyValue)

This method allows to set value of class (if property is static) or object property

### TestHelper::getMethod($className, $methodName)

This method allows to get class method (include private/protected)

### getProperty($classNameOrObject, $propertyName)

This method allows to get class property (include private/protected)

### invokeMethod($classNameOrObject, $methodName, [$parameters])

This method provide ability to call private/protected methods in the object
