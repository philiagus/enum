# Enum
Various implementation of Enums to pick and choose

## Philiagus\Enum\ConstantEnumTrait
The ConstantEnumTrait treats every constant available in the class as valid Enum Values of the class.
Simply `use` it as a trait in the class you want to use as an Enum. The Trait provides multiple methods:
- `enumAll(): array`

  Lists all the enums of the class as an array. The key is the constant name, the value is the value of the enum.
- `enumHas($value): bool`

  Returns `true` if the provided value is the same as the value of one of the constants of this class.

- `enumAssert($value): void`

  Asserts that the provided value is the same as the value of one of the constants of this class. An `Philiagus\Enum\Exception\InvalidEnumException` is thrown if the provided value is not valid.

- `enumAssertArray(array $values): void`

  Asserts that every element in the array is a valid enum and throws `Philiagus\Enum\Exception\ValuesNotInEnumException` with the invalid values if any are present. 

## Philiagus\Enum\PublicConstantEnumTrait
Works exaclty like the `Philiagus\Enum\ConstantEnumTrait`, but only treats public constants as valid values.

## Philiagus\Enum\CommentEnum
This implementation provides Enums that are implementations of the class providing the Enum, so we are talking real Objects here with all the benefits of type-hinting and the likes.

```php
<?php

/**
 * @method static SomeEnum VALUE_ONE
 * @method static SomeEnum VALUE_TWO
 */
class SomeEnum extends \Philiagus\Enum\CommentEnum
{
}

$anEnumValue = SomeEnum::VALUE_ONE();

function doSomething(SomeEnum $value): void
{
    switch ($value) { // objects work with switch construct
        case SomeEnum::VALUE_ONE():
            echo 'ONE';
            break;
        case SomeEnum::VALUE_TWO();
            echo 'TWO';
            break;
    }
}

doSomething($anEnumValue); // would print 'ONE'

var_dump(SomeEnum::all());
/*
Prints an array with the keys being the enum names (VALUE_OND and VALUE_TWO) and the values being the corresponding enum instances.
*/
```

This example creates an Enum class with the valid enum values `VALUE_ONE` and `VALUE_TWO`. These are later retrieved using the methods themselves.

**But why methods?**

Answer: These can be hinted to and usages of them found by most IDEs.  

**Can I add my own methods to the class?**

Yes! With this you can add functionality or more information to your enums.