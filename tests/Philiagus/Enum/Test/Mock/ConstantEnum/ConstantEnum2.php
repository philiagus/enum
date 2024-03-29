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

namespace Philiagus\Enum\Test\Mock\ConstantEnum;

class ConstantEnum2 extends ConstantEnum1
{

    public const VALUE4 = 'value4';
    protected const VALUE5 = 'value5';
    private const VALUE6 = 'value6';

}