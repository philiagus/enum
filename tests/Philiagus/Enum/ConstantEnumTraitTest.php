<?php
declare(strict_types=1);

namespace Philiagus\test\Enum;

use Philiagus\Enum\Exception\EnumGenerationException;
use Philiagus\Enum\Exception\InvalidEnumException;
use PHPUnit\Framework\TestCase;

use Philiagus\Test\Enum\Mock\ConstantEnum1 as Enum1;
use Philiagus\Test\Enum\Mock\ConstantEnum2 as Enum2;

class ConstantEnumTraitTest extends TestCase
{

    /**
     * @throws EnumGenerationException
     */
    public function testThatClassHasOwnAndParentEnums(): void
    {
        self::assertEquals(
            [
                'VALUE1' => 'value1',
                'VALUE3' => 'value3',
                'VALUE4' => 'value4',
                'VALUE5' => 'value5',
                'VALUE6' => 'value6',
            ],
            Enum2::enumAll()
        );

        self::assertEquals(
            [
                'VALUE1' => 'value1',
                'VALUE2' => 'value2',
                'VALUE3' => 'value3',
            ],
            Enum1::enumAll()
        );
    }

    /**
     * @throws EnumGenerationException
     */
    public function testValidAssertion(): void
    {
        self::expectNotToPerformAssertions();
        Enum1::enumAssert('value1');
    }

    /**
     * @throws EnumGenerationException
     */
    public function testInvalidAssertion(): void
    {
        self::expectException(InvalidEnumException::class);
        Enum1::enumAssert('not in the list');
    }

    /**
     * @throws EnumGenerationException
     */
    public function testHas(): void
    {
        self::assertTrue(Enum1::enumHas(Enum1::VALUE1));
        self::assertTrue(Enum1::enumHas('value2'));
        self::assertFalse(Enum1::enumHas('not in the list'));
    }

}