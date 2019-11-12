<?php
declare(strict_types=1);

namespace Philiagus\Enum\Exception;

class ValueNotInEnumException extends \OutOfBoundsException
{

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $class;

    /**
     * InvalidEnumException constructor.
     *
     * @param string $class
     * @param $value
     */
    public function __construct(string $class, $value)
    {
        parent::__construct(
            "The provided value is not a valid $class enum"
        );
        $this->value = $value;
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

}