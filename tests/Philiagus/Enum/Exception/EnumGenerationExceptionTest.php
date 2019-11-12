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

use Exception;
use Philiagus\Enum\Exception\EnumGenerationException;
use PHPUnit\Framework\TestCase;

class EnumGenerationExceptionText extends TestCase
{
    public function testClass(): void
    {
        $parent = new Exception();
        $exception = new EnumGenerationException('msg', 'class', $parent);
        self::assertSame('class', $exception->getClass());
        self::assertSame('msg', $exception->getMessage());
        self::assertSame($parent, $exception->getPrevious());
    }
}