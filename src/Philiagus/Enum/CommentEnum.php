<?php
declare(strict_types=1);

namespace Philiagus\Enum;

use Philiagus\Enum\Exception\EnumGenerationException;
use Philiagus\Enum\Exception\InvalidEnumException;

class CommentEnum
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private static $instances = [];

    /**
     * CommentEnum constructor.
     *
     * @param string $name
     */
    final private function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return static
     * @throws EnumGenerationException
     */
    final public static function __callStatic(string $name, array $arguments)
    {
        self::populateInstances();
        $class = static::class;

        if(!isset(self::$instances[$class][$name])) {
            throw new InvalidEnumException($class, $name);
        }

        if($arguments) {
            throw new EnumGenerationException(
                "No arguments are allowed when creating the enum for class $class"
            );
        }

        return self::$instances[$class][$name];
    }

    /**
     * @throws EnumGenerationException
     */
    private static function populateInstances(): void
    {
        if(isset(self::$instances[static::class])) return;
        $class = static::class;
        try {
            $reflection = new \ReflectionClass(static::class);
            // @codeCoverageIgnoreStart
        } catch (\Exception $e) {
            throw new EnumGenerationException("Enum values for class $class could not be extracted", 0, $e);
        }
        // @codeCoverageIgnoreEnd
        $comment = $reflection->getDocComment();
        if(!$comment || !preg_match_all('/@method\h+static\h+\S*\h+(?<name>[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)/i', $comment, $matches)) {
            throw new EnumGenerationException("The class $class does not provide a docblock containing the valid enum values in '@method static self ENUM()' notation");
        }

        $instances = [];
        foreach($matches['name'] as $enumName) {
            $instances[$enumName] = new static($enumName);
        }

        self::$instances[$class] = $instances;
    }

    /**
     * @return array
     * @throws EnumGenerationException
     */
    final public static function all(): array
    {
        self::populateInstances();

        return self::$instances[static::class];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}