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

namespace Philiagus\Test\Enum\Mock;

use Philiagus\Enum\ConstantEnumTrait;

class ConstantEnum1
{

    use ConstantEnumTrait;

    public const VALUE1 = 'value1';
    private const VALUE2 = 'value2';
    protected const VALUE3 = 'value3';

}