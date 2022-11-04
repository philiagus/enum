# UPDATE
#### v2.0.0 - v2.1.0

**WARNING**: This update adds support for PHP8.1 and removes support for PHP<8.0

**WARNING**: This will be the last update, as this package will be abandoned in favour of the PHP8.1 language level enums.

## v1.0.2 - v2.0.0

### BREAKING CHANGES
- Enums no longer support `getIndex()`. If this is needed for your project, please implement `getIndex()` yourself in the corresponding classes with chosen values.

  *Reason*: One of the goals of this update was to implement enum inheritance - an enum `BaseColor` can be extended by `ExtendednColor`. As `ExtendedColor` would contain all colors of `BaseColor` there is no "one size fits all" way of distributing index between the two classes. Every way seems to be wrong, thus we opted to remove the index and leave numbering to the implementation.*

- Enums that extend other enums will now also contain the parent enum values.

  *Reason*: Previously extending enums would have been a no-go for this framework. The child enums wouldn't contain the parent enum values but for type-checks they would still have counted as valid instances. This has been changed.

- `__set` method of the `CommentEnum` is now final and will always throw an exception.
  
  *Reason*: Enums should provide information, not be loaded with dynamic information form the outside on demand. This is to protect the enums from being loaded with unexpected values and keeping the behaviour of `CommentEnum` and `CommentValuesEnum` in line. However, you can still load these Enums with your own properties inside the classes, if you so desire.

### New Features

#### CommentEnum

- Enums can now correctly inherit other enums.

```php
/**
 * @method static self RED
 * @method static self GREEN
 * @method static self BLUE
 */
class BaseColors extends \Philiagus\Enum\CommentEnum {

}



/**
 * @method static self PINK
 * @method static self YELLOW
 */
class MoreColors extends BaseColors {

}
```
In this example `MoreColors` will contain `RED`, `GREEN` and `BLUE` as well.



#### CommentValuesEnum

This works exactly as the improved CommentEnums, but information can be added to the individual enum values in a JSON format. The JSON must be in the same line as the defining value, must be an object on top level and must not contain newlines. Invalid JSON will lead to an exception on Enum generation.

```php
/**
 * @method static self RED {"r":255,"g":0,"b":0}
 * @method static self GREEN {"r":0,"g":255,"b":0} 
 * @method static self BLUE {"r":0,"g":0,"b":255} 
 */
class BaseColors extends \Philiagus\Enum\CommentValuesEnum {

    public function getGreen(): int
    {
        return $this->getValue('g');
    }
}
```

If a value is not set for the enum, `getValue` will return `null`. `hasValue` returns a bool `true` if the definfed value is given for the property in question. Both `getValue` and `setValue` are protected and thus must be exposed using dedicated methods.

You can also use `@property-read` to expose these values public. The type-hint of `@propert-read` will not be ignored by the implementation. The name of the value/property must be the last not space element of the `@property-read` line. If a value of that name is given in the JSON the property will read to that value, `null` will be returned otherwise.

Properties of the enum cannot be set.

```php
/**
 * @method static self RED {"r":255,"g":0,"b":0}
 * @method static self GREEN {"r":0,"g":255,"b":0} 
 * @method static self BLUE {"r":0,"g":0,"b":255} 
 * @property-read int $r
 * @property-read int $g
 * @property-read int $b
 */
class BaseColors extends \Philiagus\Enum\CommentValuesEnum {
}

echo BaseColors::RED()->r; // 255
```
