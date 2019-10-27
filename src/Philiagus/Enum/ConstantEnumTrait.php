<?php
declare(strict_types=1);

namespace Philiagus\Enum;

use Philiagus\Enum\Exception\EnumGenerationException;
use Philiagus\Enum\Exception\InvalidEnumException;

/**
 * All constants of the class are valid enum values
 *
 * @package Philiagus\Enum
 */
trait ConstantEnumTrait
{

    /**
     * @return array
     * @throws EnumGenerationException
     */
    public static function enumAll(): array
    {
        $class = static::class;
        static $enums = [];
        if (!isset($enums[$class])) {
            $extracted = [];
            try {
                $reflection = new \ReflectionClass($class);
                // @codeCoverageIgnoreStart
            } catch (\Exception $e) {
                throw new EnumGenerationException("Enum values for class $class could not be extracted", 0, $e);
            }
            // @codeCoverageIgnoreEnd

            foreach ($reflection->getReflectionConstants() as $constant) {
                $extracted[$constant->getName()] = $constant->getValue();
            }
            $enums[$class] = $extracted;
        }

        return $enums[$class];
    }

    /**
     * Validates that the provided value is one of the values of this enum
     *
     * @param $value
     *
     * @return bool
     * @throws EnumGenerationException
     */
    public static function enumHas($value): bool
    {
        return in_array($value, self::enumAll(), true);
    }

    /**
     * @param $value
     *
     * @throws EnumGenerationException
     */
    public static function enumAssert($value): void
    {
        if (self::enumHas($value)) return;

        throw new InvalidEnumException(static::class, $value);
    }
}