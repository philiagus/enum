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

namespace Philiagus\test\Enum;

use Philiagus\Enum\Exception\EnumGenerationException;
use Philiagus\Enum\Exception\ValueNotInEnumException;
use Philiagus\Enum\Exception\ValuesNotInEnumException;
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
        self::expectException(ValueNotInEnumException::class);
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

    /**
     * @throws EnumGenerationException
     */
    public function testValidAssertArray(): void
    {
        self::expectNotToPerformAssertions();
        Enum1::enumAssertArray(['value1']);
    }

    /**
     * @throws EnumGenerationException
     */
    public function testInvalidAssertArray(): void
    {
        $this->expectException(ValuesNotInEnumException::class);
        try {
            Enum1::enumAssertArray(['value1', 'not in']);
        } catch (ValuesNotInEnumException $e) {
            self::assertSame(['not in'], $e->getValues());
            throw $e;
        }
    }

}