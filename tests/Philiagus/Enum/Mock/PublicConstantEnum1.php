<?php
declare(strict_types=1);

namespace Philiagus\Test\Enum\Mock;

use Philiagus\Enum\PublicConstantEnumTrait;

class PublicConstantEnum1 {

    use PublicConstantEnumTrait;

    public const VALUE1 = 'value1';
    private const VALUE2 = 'value2';
    protected const VALUE3 = 'value3';

}