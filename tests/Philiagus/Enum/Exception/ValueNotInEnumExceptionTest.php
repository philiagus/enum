<?php
declare(strict_types=1);

namespace Philiagus\test\Enum\Exception;

use Philiagus\Enum\Exception\ValueNotInEnumException;
use PHPUnit\Framework\TestCase;

class ValueNotInEnumExceptionTest extends TestCase
{

    public function testClass(): void
    {
        $exception = new ValueNotInEnumException('class', 'value');
        self::assertSame('class', $exception->getClass());
        self::assertSame('value', $exception->getValue());
        self::assertSame('The provided value is not a valid class enum', $exception->getMessage());
    }

}