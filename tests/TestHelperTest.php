<?php
namespace Aivus\TestHelper\Tests;

use Aivus\TestHelper\exceptions\InvalidArgumentException;
use Aivus\TestHelper\TestHelper;

class TestHelperTest extends \PHPUnit_Framework_TestCase
{
    /** @var TestHelper */
    private $testHelper;

    protected function setUp()
    {
        $this->testHelper = new TestHelper();
    }

    public function testGetPropertyValueWithClassNameAndPrivateStaticProperty()
    {
        $actual = $this->testHelper->getPropertyValue('Aivus\TestHelper\Tests\TestClass', 'privateStaticProperty');
        $this->assertEquals('privateStaticPropertyValue', $actual);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetPropertyValueWithClassNameAndPrivateNonStaticPropertyThrowException()
    {
        $this->testHelper->getPropertyValue('Aivus\TestHelper\Tests\TestClass', 'privateProperty');
    }

    public function testGetPropertyValueWithObjectAndPrivateProperty()
    {
        $testClass = new TestClass();
        $actual    = $this->testHelper->getPropertyValue($testClass, 'privateProperty');
        $this->assertEquals('privatePropertyValue', $actual);
    }

    public function testSetPropertyValueWithClassNameAndPrivateStaticProperty()
    {
        $this->testHelper->setPropertyValue(
            'Aivus\TestHelper\Tests\TestClass',
            'privateStaticProperty',
            'newPrivateStaticProperty'
        );

        $reflection = new \ReflectionClass('Aivus\TestHelper\Tests\TestClass');
        $property   = $reflection->getProperty('privateStaticProperty');
        $property->setAccessible(true);
        $actual = $property->getValue();

        $this->assertEquals('newPrivateStaticProperty', $actual);

        // Restore origin class static property
        $property->setValue('privateStaticProperty');
    }


    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetPropertyValueWithClassNameAndPrivateNonStaticPropertyThrowException()
    {
        $this->testHelper->setPropertyValue(
            'Aivus\TestHelper\Tests\TestClass',
            'privateProperty',
            'newPrivateStaticProperty'
        );
    }

    public function testSetPropertyValueWithObjectAndPrivateProperty()
    {
        $testClass = new TestClass();
        $this->testHelper->setPropertyValue($testClass, 'privateProperty', 'newPrivatePropertyValue');

        $reflection = new \ReflectionClass($testClass);
        $property   = $reflection->getProperty('privateProperty');
        $property->setAccessible(true);
        $actual = $property->getValue($testClass);

        $this->assertEquals('newPrivatePropertyValue', $actual);
    }

    public function testGetMethodWithClassName()
    {
        $actualMethod = $this->testHelper->getMethod('Aivus\TestHelper\Tests\TestClass', 'privateStaticMethod');

        $reflection     = new \ReflectionClass('Aivus\TestHelper\Tests\TestClass');
        $expectedMethod = $reflection->getMethod('privateStaticMethod');


        $this->assertEquals($expectedMethod, $actualMethod);
    }

    public function testGetMethodWithObject()
    {
        $testClass    = new TestClass();
        $actualMethod = $this->testHelper->getMethod($testClass, 'privateMethod');

        $reflection     = new \ReflectionClass('Aivus\TestHelper\Tests\TestClass');
        $expectedMethod = $reflection->getMethod('privateMethod');


        $this->assertEquals($expectedMethod, $actualMethod);
    }

    public function testGetPropertyWithClassNameAndStaticProperty()
    {
        $actualStaticProperty   = $this->testHelper->getProperty('Aivus\TestHelper\Tests\TestClass', 'privateStaticProperty');
        $reflection             = new \ReflectionClass('Aivus\TestHelper\Tests\TestClass');
        $expectedStaticProperty = $reflection->getProperty('privateStaticProperty');

        $this->assertEquals($expectedStaticProperty, $actualStaticProperty);
    }

    public function testGetPropertyWithObject()
    {
        $testClass        = new TestClass();
        $actualProperty   = $this->testHelper->getProperty($testClass, 'privateProperty');
        $reflection       = new \ReflectionClass('Aivus\TestHelper\Tests\TestClass');
        $expectedProperty = $reflection->getProperty('privateProperty');

        $this->assertEquals($expectedProperty, $actualProperty);
    }

    public function testInvokeMethodWithObject()
    {
        $testClass = new TestClass();
        $expectedArgs = ['some' => 'args', 'for', 'invoke' => 'method'];
        $actualResult = $this->testHelper->invokeMethod($testClass, 'privateMethodForInvoke', [$expectedArgs]);

        $this->assertEquals($expectedArgs, $actualResult);
    }

    public function testInvokeMethodWithClassName()
    {
        $testClass = new TestClass();
        $expectedArgs = ['some' => 'args', 'for', 'invoke' => 'method'];
        $actualResult = $this->testHelper->invokeMethod($testClass, 'privateMethodForInvoke', [$expectedArgs]);

        $this->assertEquals($expectedArgs, $actualResult);
    }

    public function testInvokeMethodWithClassNameAndStaticClass()
    {
        $expectedArgs = ['some' => 'args', 'for', 'invoke' => 'method'];
        $actualResult = $this->testHelper->invokeMethod('Aivus\TestHelper\Tests\TestClass', 'privateStaticMethodForInvoke', [$expectedArgs]);

        $this->assertEquals($expectedArgs, $actualResult);
    }


}

class TestClass
{
    private $privateProperty = 'privatePropertyValue';
    private static $privateStaticProperty = 'privateStaticPropertyValue';

    private static function privateStaticMethod($args = null)
    {
        //
    }

    private function privateMethod($args = null)
    {
        //
    }

    private function privateMethodForInvoke($args = null)
    {
        return $args;
    }

    private static function privateStaticMethodForInvoke($args = null)
    {
        return $args;
    }
}
