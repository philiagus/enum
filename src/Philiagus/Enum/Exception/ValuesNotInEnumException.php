<?php
declare(strict_types=1);

namespace Philiagus\Enum\Exception;

class ValuesNotInEnumException extends \OutOfBoundsException
{

    /**
     * @var mixed[]
     */
    private $values;

    /**
     * @var string
     */
    private $class;

    /**
     * InvalidEnumException constructor.
     *
     * @param string $class
     * @param mixed[] $values
     */
    public function __construct(string $class, array $values)
    {
        parent::__construct(
            "The provided values are not valid $class enums"
        );
        $this->values = $values;
        $this->class = $class;
    }

    /**
     * @return mixed[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

}