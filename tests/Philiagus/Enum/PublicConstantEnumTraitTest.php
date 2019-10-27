<?php
declare(strict_types=1);

namespace Philiagus\test\Enum;

use Philiagus\Enum\Exception\EnumGenerationException;
use Philiagus\Enum\Exception\InvalidEnumException;
use PHPUnit\Framework\TestCase;

use Philiagus\Test\Enum\Mock\PublicConstantEnum1 as Enum1;
use Philiagus\Test\Enum\Mock\PublicConstantEnum2 as Enum2;

class PublicConstantEnumTraitTest extends TestCase
{

    /**
     * @throws EnumGenerationException
     */
    public function testThatClassHasOwnAndParentEnums(): void
    {
        self::assertEquals(
            [
                'VALUE1' => 'value1',
                'VALUE4' => 'value4',
            ],
            Enum2::enumAll()
        );

        self::assertEquals(
            [
                'VALUE1' => 'value1',
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
        self::assertFalse(Enum1::enumHas('value2'));
        self::assertFalse(Enum1::enumHas('not in the list'));
    }

}