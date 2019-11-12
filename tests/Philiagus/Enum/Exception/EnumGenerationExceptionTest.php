<?php
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