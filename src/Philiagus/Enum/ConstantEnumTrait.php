<?php
/**
 * This file is part of philiagus/enum
 *
 * (c) Andreas Bittner <philiagus@philiagus.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Philiagus\Enum;

use Philiagus\Enum\Exception\EnumGenerationException;
use Philiagus\Enum\Exception\ValueNotInEnumException;
use Philiagus\Enum\Exception\ValuesNotInEnumException;

/**
 * All constants of the class are valid enum values
 *
 * @package Philiagus\Enum
 */
trait ConstantEnumTrait
{
    /**
     * Returns the list of constants defined in this class
     *
     * @return mixed[]
     * @throws EnumGenerationException
     */
    final public static function enumAll(): array
    {
        static $constants = [];
        $className = static::class;
        if (!isset($constants[$className])) {
            try {
                $reflection = new \ReflectionClass($className);
                $constants[$className] = [];
                foreach ($reflection->getReflectionConstants() as $reflectionConstant) {
                    $constants[$className][$reflectionConstant->getName()] = $reflectionConstant->getValue();
                }
                // @codeCoverageIgnoreStart
            } catch (\ReflectionException $e) {
                throw new EnumGenerationException("Enum values for class $className could not be extracted", $className);
            }
            // @codeCoverageIgnoreEnd
        }

        return $constants[$className];
    }

    /**
     * Checks if the given value is one of the values in this class and if not throws an exception
     *
     * @param mixed $value
     *
     * @throws ValueNotInEnumException
     * @throws EnumGenerationException
     */
    final public static function enumAssert($value)
    {
        if (self::enumHas($value)) return;

        throw new ValueNotInEnumException(static::class, $value);
    }

    /**
     * Checks if a given value is listed in the enums
     *
     * @param mixed $value
     *
     * @return bool
     *
     * @throws EnumGenerationException
     */
    final public static function enumHas($value): bool
    {
        return in_array($value, self::enumAll(), true);
    }

    /**
     * Checks an array of elements if all of them are valid enums of the class
     *
     * @param array $values
     *
     * @throws ValuesNotInEnumException
     * @throws EnumGenerationException
     */
    final public static function enumAssertArray(array $values)
    {
        $notPresent = [];
        $all = self::enumAll();
        foreach ($values as $value) {
            if (!in_array($value, $all, true)) {
                $notPresent[] = $value;
            }
        }
        if (empty($notPresent)) return;

        throw new ValuesNotInEnumException(static::class, $notPresent);
    }
}