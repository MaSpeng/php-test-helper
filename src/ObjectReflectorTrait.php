<?php declare(strict_types=1);
/**
 * This file is part of the PHP test helper project.
 *
 * @author Marco Spengler <MaSpeng@outlook.de>
 */

namespace MaSpeng\TestHelper;

/**
 * Object reflector trait
 *
 * @package MaSpeng\TestHelper
 */
trait ObjectReflectorTrait
{
    /**
     * Get method by reflection.
     *
     * @param string $class
     * @param string $method
     *
     * @return \ReflectionMethod
     *
     * @throws \ReflectionException
     */
    public static function getMethod(string $class, string $method): \ReflectionMethod
    {
        $reflectionMethod = new \ReflectionMethod($class, $method);

        $reflectionMethod->setAccessible(true);

        return $reflectionMethod;
    }

    /**
     * Invoke method by reflection.
     *
     * @param object $object
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     *
     * @throws \ReflectionException
     * @throws \InvalidArgumentException
     */
    public static function invokeMethod(object $object, string $method, array $args = [])
    {
        $class = self::getClassName($object);

        $reflectionMethod = self::getMethod($class, $method);

        return $reflectionMethod->invokeArgs($object, $args);
    }

    /**
     * Get property by reflection.
     *
     * @param string $class
     * @param string $property
     *
     * @return \ReflectionProperty
     *
     * @throws \ReflectionException
     */
    public static function getProperty(string $class, string $property): \ReflectionProperty
    {
        $reflectionProperty = new \ReflectionProperty($class, $property);

        $reflectionProperty->setAccessible(true);

        return $reflectionProperty;
    }

    /**
     * Get property value.
     *
     * @param object $object
     * @param string $property
     *
     * @return mixed
     *
     * @throws \ReflectionException
     * @throws \InvalidArgumentException
     */
    public static function getPropertyValue(object $object, string $property)
    {
        $class = static::getClassName($object);

        $reflectionProperty = self::getProperty($class, $property);

        return $reflectionProperty->getValue($object);
    }

    /**
     * Set property value by reflection.
     *
     * @param object $object
     * @param string $property
     * @param mixed  $value
     *
     * @throws \ReflectionException
     * @throws \InvalidArgumentException
     */
    public static function setPropertyValue(object $object, string $property, $value): void
    {
        $class = self::getClassName($object);

        $reflectionProperty = self::getProperty($class, $property);

        $reflectionProperty->setValue($object, $value);
    }

    /**
     * Set property values
     *
     * @param object  $object
     * @param mixed[] $propertyMap
     *
     * @throws \ReflectionException
     * @throws \InvalidArgumentException
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
     * Get class name
     *
     * @param object $object
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    private static function getClassName(object $object): string
    {
        $class = \get_class($object);
        if (false === strpos($class, 'Mock_')) {
            return $class;
        }

        $class = \get_parent_class($object);

        if (false === $class) {
            throw new \InvalidArgumentException('Unable to get class from provided object.');
        }

        return $class;
    }
}
