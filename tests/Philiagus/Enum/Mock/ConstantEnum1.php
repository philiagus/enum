<?php
declare(strict_types=1);

namespace Philiagus\Test\Enum\Mock;

use Philiagus\Enum\ConstantEnumTrait;

class ConstantEnum1 {

    use ConstantEnumTrait;

    public const VALUE1 = 'value1';
    private const VALUE2 = 'value2';
    protected const VALUE3 = 'value3';

}