<?php

declare(strict_types=1);

/**
 * This file is part of the PHP test helper project.
 *
 * @author Marco Spengler <MaSpeng@outlook.de>
 */

namespace MaSpeng\TestHelper;

use InvalidArgumentException;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

trait ObjectReflectorTrait
{
    /**
     * @throws ReflectionException
     */
    public static function getMethod(string $class, string $method): ReflectionMethod
    {
        $reflectionMethod = new ReflectionMethod($class, $method);

        $reflectionMethod->setAccessible(true);

        return $reflectionMethod;
    }

    /**
     * @param array<mixed> $args
     *
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public static function invokeMethod(object $object, string $method, array $args = []): mixed
    {
        $class = self::getClassName($object);

        $reflectionMethod = self::getMethod($class, $method);

        return $reflectionMethod->invokeArgs($object, $args);
    }

    /**
     * @throws ReflectionException
     */
    public static function getProperty(string $class, string $property): ReflectionProperty
    {
        $reflectionProperty = new ReflectionProperty($class, $property);

        $reflectionProperty->setAccessible(true);

        return $reflectionProperty;
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public static function getPropertyValue(object $object, string $property): mixed
    {
        $class = static::getClassName($object);

        $reflectionProperty = self::getProperty($class, $property);

        return $reflectionProperty->getValue($object);
    }

    /**
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public static function setPropertyValue(object $object, string $property, mixed $value): void
    {
        $class = self::getClassName($object);

        $reflectionProperty = self::getProperty($class, $property);

        $reflectionProperty->setValue($object, $value);
    }

    /**
     * @param array<mixed> $propertyMap
     *
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public static function setPropertyValues(object $object, array $propertyMap): void
    {
        $class = self::getClassName($object);

        foreach ($propertyMap as $property => $value) {
            $reflectionProperty = self::getProperty($class, $property);

            $reflectionProperty->setValue($object, $value);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    private static function getClassName(object $object): string
    {
        $class = $object::class;
        if (!str_contains($class, 'Mock_') && !str_contains($class, 'MockObject_')) {
            return $class;
        }

        $class = get_parent_class($object);

        if (false === $class) {
            throw new InvalidArgumentException('Unable to get class from provided object.');
        }

        return $class;
    }
}
