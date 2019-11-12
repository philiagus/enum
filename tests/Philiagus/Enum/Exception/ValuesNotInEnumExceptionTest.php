<?php
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