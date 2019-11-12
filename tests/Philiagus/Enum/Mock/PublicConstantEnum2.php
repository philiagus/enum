<?php
declare(strict_types=1);

namespace Philiagus\Test\Enum\Mock;

class PublicConstantEnum2 extends PublicConstantEnum1
{

    public const VALUE4 = 'value4';
    protected const VALUE5 = 'value5';
    private const VALUE6 = 'value6';

}