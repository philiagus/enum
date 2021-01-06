<?php
declare(strict_types=1);

namespace Philiagus\Enum\Test\Mock\CommentValuesEnum;

use Philiagus\Enum\CommentValuesEnum;

/**
 * Class Enum1
 *
 * @package Philiagus\Enum\Test\Mock\CommentProperty
 * @property-read int $v
 * @method static self VALUE1 {"v":1,"hidden":"hidden1"}
 * @method static self VALUE2 {"v":2,"hidden":"hidden2"}
 */
class Enum1 extends CommentValuesEnum {

    public function getHidden(): ?string
    {
        return $this->getValue('hidden');
    }

    public function hasValue(string $value): bool
    {
        return parent::hasValue($value);
    }
}