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

class CommentEnum implements \Serializable
{

    /**
     * @var int[][]
     */
    private static $validValues = [];

    /**
     * @var self[][]
     */
    private static $instances = [];

    /**
     * @var string
     */
    private $enum;

    /**
     * @param string $enum
     */
    final private function __construct(string $enum)
    {
        $this->enum = $enum;
    }

    /**
     * @return string
     */
    final public function getName(): string
    {
        return $this->enum;
    }

    /**
     * @return int
     */
    final protected function getIndex(): int
    {
        return self::$validValues[static::class][$this->enum];
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
     * @throws EnumGenerationException
     */
    private static function init(): void
    {
        $class = static::class;
        if (!isset(self::$validValues[$class])) {
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
            $comment = $reflection->getDocComment();
            if (!$comment) {
                throw new EnumGenerationException("Docblock of $class could not be read for creation of CommentEnum pattern", $class);
            }
            if (preg_match_all('/@method\s+(?P<definition>.*?)\s*$/im', $reflection->getDocComment(), $matches)) {
                $methodDefinitions = $matches['definition'];
                $duplicates = [];
                foreach ($methodDefinitions as $index => $definition) {
                    if (!preg_match('/^static\s+[^\s]+\s+(?P<enum>[a-z_\x80-\xff][a-z0-9_\x80-\xff]*?)\s*$/i', $definition, $matches)) {
                        throw new EnumGenerationException("Enum definition '$definition' of class '$class' does not conform to '@method static <classname> <enumname>' pattern", $class);
                    }
                    $enum = $matches['enum'];
                    if (isset($enums[$enum])) {
                        $duplicates[] = $enum;
                        continue;
                    }
                    $enums[$enum] = $index;
                }

                if (!empty($duplicates)) {
                    throw new EnumGenerationException("Enum class $class contains duplicate enum definitions for: " . implode(', ', array_unique($duplicates)), $class);
                }

            }

            self::$validValues[$class] = $enums;
        }
    }

    /**
     * @return static[]
     * @throws EnumGenerationException
     */
    final public static function all(): array
    {
        static::init();
        $all = [];
        foreach (self::$validValues[static::class] as $enum => $_) {
            $all[] = static::byName($enum);
        }

        return $all;
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
        if (isset(self::$instances[$class][$name])) {
            return self::$instances[$class][$name];
        }

        static::init();

        if (!isset(self::$validValues[$class][$name])) {
            throw new ValueNotInEnumException(static::class, $name);
        }

        return self::$instances[$class][$name] = new static($name);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->enum;
    }

    /**
     * @throws \LogicException
     */
    final public function __clone()
    {
        throw new \LogicException('Enums cannot be cloned');
    }

    /**
     * @inheritDoc
     */
    final public function serialize()
    {
        throw new \LogicException('Enums cannot be serialized or put to sleep');
    }

    /**
     * @inheritDoc
     */
    final public function unserialize($serialized)
    {
        throw new \LogicException('Enums cannot be deserialized or woken up');
    }
}