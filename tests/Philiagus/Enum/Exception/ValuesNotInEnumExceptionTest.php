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

namespace Philiagus\test\Enum\Exception;

use Philiagus\Enum\Exception\ValuesNotInEnumException;
use PHPUnit\Framework\TestCase;

class ValuesNotInEnumExceptionTest extends TestCase
{

    public function testClass(): void
    {
        $exception = new ValuesNotInEnumException('class', ['value']);
        self::assertSame('class', $exception->getClass());
        self::assertSame(['value'], $exception->getValues());
        self::assertSame("The provided values are not valid class enums", $exception->getMessage());
    }

}