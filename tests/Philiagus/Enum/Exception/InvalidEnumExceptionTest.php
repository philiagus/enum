<?php
declare(strict_types=1);

namespace Philiagus\test\Enum\Exception;

use Philiagus\Enum\Exception\InvalidEnumException;
use PHPUnit\Framework\TestCase;

class InvalidEnumExceptionTest extends TestCase
{

    public function testClass(): void
    {
        $exception = new InvalidEnumException('class', 'value');
        self::assertSame('class', $exception->getClass());
        self::assertSame('value', $exception->getValue());
    }

}