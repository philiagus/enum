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

class CommentValuesEnum
{

    /**
     * @var self[][]
     */
    private static $instances = [];
    /**
     * @var string[][]
     */
    private static $exposedValues = [];
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $values;

    /**
     * @param string $enum
     * @param array $values
     */
    final private function __construct(string $enum, array $values)
    {
        $this->name = $enum;
        $this->values = $values;
    }

    /**
     * @param string $enum
     * @param array $arguments
     *
     * @return static
     * @throws EnumGenerationException
     */
    final public static function __callStatic(string $enum, array $arguments): self
    {
        if (!empty($arguments)) {
            throw new \LogicException('No arguments to enum allowed');
        }

        return static::byName($enum);
    }

    /**
     * @param string $name
     *
     * @return static
     * @throws EnumGenerationException
     * @throws ValueNotInEnumException
     */
    final public static function byName(string $name): self
    {
        $class = static::class;
        static::init();
        if (isset(self::$instances[$class][$name])) {
            return self::$instances[$class][$name];
        }

        throw new ValueNotInEnumException(static::class, $name);
    }

    /**
     * @throws EnumGenerationException
     */
    private static function init(): void
    {
        $class = static::class;
        if (!isset(self::$instances[$class])) {
            if ($class === self::class) {
                throw new \LogicException("$class cannot be used as enum class");
            }

            try {
                $reflection = new \ReflectionClass($class);
                // @codeCoverageIgnoreStart
            } catch (\ReflectionException $exception) {
                throw new EnumGenerationException("Could not load reflection of class $class to parse enum definition", $class, $exception);
            }
            // @codeCoverageIgnoreEnd

            $enums = [];
            $exposedValues = [];
            $comment = $reflection->getDocComment();
            if (!$comment) {
                throw new EnumGenerationException("Docblock of $class could not be read for creation of CommentEnum pattern", $class);
            }

            if (preg_match_all('/@property-read(?:.*?)?\s+\$(?<prop>\w+)\s*$/im', $comment, $matches)) {
                $exposedValues = $matches['prop'];
            }

            if (preg_match_all('/@method\s+(?P<definition>.*?)\s*$/im', $comment, $matches)) {
                $methodDefinitions = $matches['definition'];
                $duplicates = [];
                foreach ($methodDefinitions as $index => $definition) {
                    if (!preg_match('/^static\s+[^\s]+\s+(?P<enum>[a-z_\x80-\xff][a-z0-9_\x80-\xff]*?)\s+(?P<data>.*)$/i', $definition, $matches)) {
                        throw new EnumGenerationException("Enum definition '$definition' of class '$class' does not conform to '@method static <classname> <enumname>' pattern", $class);
                    }
                    $enum = $matches['enum'];
                    if (isset($enums[$enum])) {
                        $duplicates[] = $enum;
                        continue;
                    }

                    $values = json_decode($matches['data']);
                    if (
                        json_last_error() !== JSON_ERROR_NONE ||
                        !is_object($values)
                    ) {
                        throw new EnumGenerationException("Enum class $class contains invalid JSON data for value {$matches['enum']}", $class);
                    }
                    $enums[$enum] = new static($enum, (array) $values);
                }

                if (!empty($duplicates)) {
                    throw new EnumGenerationException("Enum class $class contains duplicate enum definitions for: " . implode(', ', array_unique($duplicates)), $class);
                }
            }

            while (($reflection = $reflection->getParentClass()) && $reflection->getName() !== self::class) {
                /** @var self $parentClass */
                $parentClass = $reflection->getName();
                foreach ($parentClass::all() as $enum) {
                    $name = $enum->getName();
                    if (isset($enums[$name])) {
                        $duplicates[] = $name;
                    }

                    $enums[$name] = $enum;
                }

                if (!empty($duplicates)) {
                    throw new EnumGenerationException("Enum class $class tries to overwrite enums from parent $parentClass: " . implode(', ', array_unique($duplicates)), $class);
                }
            }

            self::$instances[$class] = $enums;
            self::$exposedValues[$class] = $exposedValues;
        }
    }

    /**
     * @return static[]
     * @throws EnumGenerationException
     */
    final public static function all(): array
    {
        static::init();

        return array_values(self::$instances[static::class]);
    }

    /**
     * @return string
     */
    final public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @throws \LogicException
     */
    final public function __clone()
    {
        throw new \LogicException('Enums cannot be cloned');
    }

    /**
     * Fully prevent serialization
     */
    final public function __serialize(): array
    {
        throw new \LogicException('Enums cannot be serialized or put to sleep');
    }


    /**
     * Fully prevent serialization
     *
     * @param array $data
     *
     * @return void
     */
    final public function __unserialize(array $data): void
    {
        throw new \LogicException('Enums cannot be deserialized or woken up');
    }

    final public function __get($property)
    {
        $class = static::class;
        if (!in_array($property, self::$exposedValues[$class])) {
            throw new \LogicException(
                "The requested property $property is not exposed or known to the enum"
            );
        }

        return $this->getValue($property);
    }

    final public function __set($name, $value)
    {
        throw new \LogicException(
            'A property of an enum cannot be set'
        );
    }

    /**
     * @param string $value
     *
     * @return mixed
     */
    protected function getValue(string $value)
    {
        return $this->values[$value] ?? null;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function hasValue(string $value): bool
    {
        return array_key_exists($value, $this->values);
    }
}
