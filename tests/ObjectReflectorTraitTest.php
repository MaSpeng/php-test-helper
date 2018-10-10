<?php declare(strict_types=1);
/**
 * This file is part of the PHP test helper project.
 *
 * @author Marco Spengler <MaSpeng@outlook.de>
 */

namespace MaSpeng\TestHelper;

use function get_class;
use MaSpeng\TestHelper\stub\Mock_Double;
use MaSpeng\TestHelper\stub\Double;
use PHPUnit\Framework\TestCase;

/**
 * Object reflector trait test class
 *
 * @package MaSpeng\TestHelper
 *
 * @covers  \MaSpeng\TestHelper\ObjectReflectorTrait
 */
class ObjectReflectorTraitTest extends TestCase
{
    /**
     * Test get method
     *
     * @return void
     */
    public function testGetMethod(): void
    {
        $testDouble = new class
        {
            /**
             * Protected method
             *
             * @return void
             */
            protected function protectedMethod(): void
            {
            }
        };

        $objectReflector = $this->getMockForTrait(ObjectReflectorTrait::class);

        $reflectedMethod = $objectReflector::getMethod(
            get_class($testDouble),
            'protectedMethod'
        );

        static::assertNull($reflectedMethod->invoke($testDouble));
    }

    /**
     * Test invoke method
     *
     * @return void
     */
    public function testInvokeMethod(): void
    {
        $testDouble = new class
        {
            /**
             * Protected method
             *
             * @return void
             */
            protected function protectedMethod(): void
            {
            }
        };

        $objectReflector = $this->getMockForTrait(ObjectReflectorTrait::class);

        static::assertNull(
            $objectReflector::invokeMethod($testDouble, 'protectedMethod')
        );
    }

    /**
     * Test get property
     *
     * @return void
     */
    public function testGetProperty(): void
    {
        $testDouble = new class
        {
            /**
             * @var string
             */
            private $privateProperty = 'private property value';

            /**
             * Get private property
             *
             * @return string
             */
            public function getPrivatePropertyValue(): string
            {
                return $this->privateProperty;
            }
        };

        $objectReflector = $this->getMockForTrait(ObjectReflectorTrait::class);

        $property = $objectReflector::getProperty(
            get_class($testDouble),
            'privateProperty'
        );

        static::assertSame($testDouble->getPrivatePropertyValue(), $property->getValue($testDouble));
    }

    /**
     * Test get property value
     *
     * @return void
     */
    public function testGetPropertyValue(): void
    {
        $testDouble = new class
        {
            /**
             * @var string
             */
            private $privateProperty = 'private property value';

            /**
             * Get private property
             *
             * @return string
             */
            public function getPrivatePropertyValue(): string
            {
                return $this->privateProperty;
            }
        };

        $objectReflector = $this->getMockForTrait(ObjectReflectorTrait::class);

        static::assertSame(
            $testDouble->getPrivatePropertyValue(),
            $objectReflector::getPropertyValue($testDouble, 'privateProperty')
        );
    }

    /**
     * Test set property value
     *
     * @return void
     */
    public function testSetPropertyValue(): void
    {
        $testDouble = new class
        {
            /**
             * @var string
             */
            private $privateProperty = 'private property value';

            /**
             * Get private property
             *
             * @return string
             */
            public function getPrivatePropertyValue(): string
            {
                return $this->privateProperty;
            }
        };

        $objectReflector = $this->getMockForTrait(ObjectReflectorTrait::class);

        $objectReflector::setPropertyValue($testDouble, 'privateProperty', 'new private property value');

        static::assertSame('new private property value', $testDouble->getPrivatePropertyValue());
    }

    /**
     * Test set property values
     *
     * @return void
     */
    public function testSetPropertyValues(): void
    {
        $testDouble = new class
        {
            /**
             * @var string
             */
            private $privateProperty = 'private property value';

            /**
             * @var string
             */
            private $anotherPrivateProperty = 'another private property value';

            /**
             * Get private property
             *
             * @return string
             */
            public function getPrivatePropertyValue(): string
            {
                return $this->privateProperty;
            }

            /**
             * Get another private property value
             *
             * @return string
             */
            public function getAnotherPrivatePropertyValue(): string
            {
                return $this->anotherPrivateProperty;
            }
        };

        $objectReflector = $this->getMockForTrait(ObjectReflectorTrait::class);

        $objectReflector::setPropertyValues(
            $testDouble,
            [
                'privateProperty' => 'new private property value',
                'anotherPrivateProperty' => 'new another private property value',
            ]
        );

        static::assertSame('new private property value', $testDouble->getPrivatePropertyValue());
        static::assertSame('new another private property value', $testDouble->getAnotherPrivatePropertyValue());
    }

    /**
     * Test get class name
     *
     * @return void
     */
    public function testGetClassName(): void
    {
        $objectReflector = $this->getMockForTrait(ObjectReflectorTrait::class);

        $mockClass = $this->createMock(Double::class);

        $getClassMethod = new \ReflectionMethod(ObjectReflectorTrait::class, 'getClassName');
        $getClassMethod->setAccessible(true);

        static::assertSame(
            Double::class,
            $getClassMethod->invoke($objectReflector, $mockClass)
        );
    }

    /**
     * Test get class name should throw exception
     *
     * @return void
     *
     * @expectedException \InvalidArgumentException
     */
    public function testGetClassNameShouldThrowException(): void
    {
        $objectReflector = $this->getMockForTrait(ObjectReflectorTrait::class);

        $getClassMethod = new \ReflectionMethod(ObjectReflectorTrait::class, 'getClassName');
        $getClassMethod->setAccessible(true);
        $getClassMethod->invoke($objectReflector, new Mock_Double());
    }
}
