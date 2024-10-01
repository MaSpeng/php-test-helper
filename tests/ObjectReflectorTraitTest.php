<?php

declare(strict_types=1);

/**
 * This file is part of the PHP test helper project.
 *
 * @author Marco Spengler <MaSpeng@outlook.de>
 */

namespace MaSpeng\TestHelper;

use InvalidArgumentException;
use MaSpeng\TestHelper\stub\Double;
use MaSpeng\TestHelper\stub\Mock_Double;
use MaSpeng\TestHelper\stub\MockObject_Double;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * @internal
 */
#[CoversClass(ObjectReflectorTrait::class)]
final class ObjectReflectorTraitTest extends TestCase
{
    public function testGetMethod(): void
    {
        $testDouble = new class {
            protected function protectedMethod(): void {}
        };

        $objectReflector = new class {
            use ObjectReflectorTrait;
        };

        $reflectedMethod = $objectReflector::getMethod(
            $testDouble::class,
            'protectedMethod',
        );

        self::assertNull($reflectedMethod->invoke($testDouble));
    }

    public function testInvokeMethod(): void
    {
        $testDouble = new class {
            protected function protectedMethod(): void {}
        };

        $objectReflector = new class {
            use ObjectReflectorTrait;
        };

        self::assertNull(
            $objectReflector::invokeMethod($testDouble, 'protectedMethod'),
        );
    }

    public function testGetProperty(): void
    {
        $testDouble = new class {
            private string $privateProperty = 'private property value';

            public function getPrivatePropertyValue(): string
            {
                return $this->privateProperty;
            }
        };

        $objectReflector = new class {
            use ObjectReflectorTrait;
        };

        $property = $objectReflector::getProperty(
            $testDouble::class,
            'privateProperty',
        );

        self::assertSame($testDouble->getPrivatePropertyValue(), $property->getValue($testDouble));
    }

    public function testGetPropertyValue(): void
    {
        $testDouble = new class {
            private string $privateProperty = 'private property value';

            public function getPrivatePropertyValue(): string
            {
                return $this->privateProperty;
            }
        };

        $objectReflector = new class {
            use ObjectReflectorTrait;
        };

        self::assertSame(
            $testDouble->getPrivatePropertyValue(),
            $objectReflector::getPropertyValue($testDouble, 'privateProperty'),
        );
    }

    public function testSetPropertyValue(): void
    {
        $testDouble = new class {
            private string $privateProperty = 'private property value';

            public function getPrivatePropertyValue(): string
            {
                return $this->privateProperty;
            }
        };

        $objectReflector = new class {
            use ObjectReflectorTrait;
        };

        $objectReflector::setPropertyValue($testDouble, 'privateProperty', 'new private property value');

        self::assertSame('new private property value', $testDouble->getPrivatePropertyValue());
    }

    public function testSetPropertyValues(): void
    {
        $testDouble = new class {
            private string $privateProperty = 'private property value';

            private string $anotherPrivateProperty = 'another private property value';

            public function getPrivatePropertyValue(): string
            {
                return $this->privateProperty;
            }

            public function getAnotherPrivatePropertyValue(): string
            {
                return $this->anotherPrivateProperty;
            }
        };

        $objectReflector = new class {
            use ObjectReflectorTrait;
        };

        $objectReflector::setPropertyValues(
            $testDouble,
            [
                'privateProperty' => 'new private property value',
                'anotherPrivateProperty' => 'new another private property value',
            ],
        );

        self::assertSame('new private property value', $testDouble->getPrivatePropertyValue());
        self::assertSame('new another private property value', $testDouble->getAnotherPrivatePropertyValue());
    }

    public function testGetClassName(): void
    {
        $objectReflector = new class {
            use ObjectReflectorTrait;
        };

        $mockClass = self::createStub(Double::class);

        $getClassMethod = new ReflectionMethod(ObjectReflectorTrait::class, 'getClassName');
        $getClassMethod->setAccessible(true);

        self::assertSame(
            Double::class,
            $getClassMethod->invoke($objectReflector, $mockClass),
        );
    }

    /**
     * @param class-string $class
     */
    #[DataProvider('getClassNameShouldThrowExceptionProvider')]
    public function testGetClassNameShouldThrowException(string $class): void
    {
        $this->expectException(InvalidArgumentException::class);

        $objectReflector = new class {
            use ObjectReflectorTrait;
        };

        $getClassMethod = new ReflectionMethod(ObjectReflectorTrait::class, 'getClassName');
        $getClassMethod->setAccessible(true);
        $getClassMethod->invoke($objectReflector, new $class());
    }

    /**
     * @return iterable<string, array{class: class-string}>
     */
    public static function getClassNameShouldThrowExceptionProvider(): iterable
    {
        yield 'Mock class' => [
            'class' => Mock_Double::class,
        ];

        yield 'MockObject class' => [
            'class' => MockObject_Double::class,
        ];
    }
}
