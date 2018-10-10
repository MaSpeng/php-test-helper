# Object Reflector

To use the `ObjectReflectorTrait` just add a use statement to your `TestClass`, as described in the following example.

```php
<?php declare(strict_types=1);

use MaSpeng\TestHelper\ObjectReflectorTrait;
use PHPUnit\Framework\TestCase;

class SubjectTest extends TestCase
{
    use ObjectReflectorTrait;
    
    // ...
}
```

## Get Object Method

To retrieve a non public method and make it accessible use `static::getMethod`

```php
public function testUseCase(): void
{
    // ...
    
    // Method from ObjectReflectorTrait
    $method = static::getMethod(Subject::class, 'useCase');

    $method->getParameters();
    
    // ...
}
```

## Invoke Object Method

To instant invoke a non public method use `static::invokeMethod`

```php
public function testUseCase(): void
{
    // ...
    
    // Method from ObjectReflectorTrait
    static::invokeMethod(
        new Subject(),
        'useCase',
        [
            'argument',
        ]
    );
    
    // ...
}
```

## Get Object Property

To retrieve a non public property and make it accessible use `static::getProperty`

```php
public function testUseCase(): void
{
    // ...
    
    // Method from ObjectReflectorTrait
    $property = static::getProperty(Subject::class, 'property');

    $property->getModifiers()
    
    // ...
}
```

## Get Object Property Value

To instant retrieve the value of a non public property use `static::getPropertyValue`

```php
public function testUseCase(): void
{
    // ...
    
    // Method from ObjectReflectorTrait
    $propertyValue = static::getPropertyValue(new Subject(), 'property');

    // ...
}
```

## Set Object Property

To set a non public object property value use `static::setPropertyValue`

```php
public function testUseCase(): void
{
    // ...

    $dependency = $this->prophesize(Dependency::class);
    $dependency->method()
        ->shouldBeCalled();

    $subject = $this->createPartialMock(Subject::class, []);

    // Method from ObjectReflectorTrait
    static::setPropertyValue($subject, 'dependency', $dependency->reveal());
    
    // ...
}
```

## Set Multiple Object Properties

To set multiple non public object property value use `static::setPropertyValues`

```php
public function testUseCase(): void
{
    // ...
    
    $dependency = $this->prophesize(Dependency::class);
    $dependency->method()
        ->shouldBeCalled();

    $subject = $this->createPartialMock(Subject::class, []);

    // Method from ObjectReflectorTrait
    static::setPropertyValues(
        $subject,
        [
            'property' => 'property value',
            'dependency' => $dependency->reveal(),
        ]
    );
    
    // ...
}
```
