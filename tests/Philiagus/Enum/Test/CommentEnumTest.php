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

namespace Philiagus\Enum\Test;

use LogicException;
use Philiagus\Enum\CommentEnum;
use Philiagus\Enum\Exception\EnumGenerationException;
use Philiagus\Enum\Exception\ValueNotInEnumException;
use Philiagus\Enum\Test\Mock\CommentEnum\Enum1;
use Philiagus\Enum\Test\Mock\CommentEnum\Duplicates;
use Philiagus\Enum\Test\Mock\CommentEnum\Invalid;
use Philiagus\Enum\Test\Mock\CommentEnum\NoComment;
use Philiagus\Enum\Test\Mock\CommentEnum\Enum1_2;
use Philiagus\Enum\Test\Mock\CommentEnum\Overwrite;
use PHPUnit\Framework\TestCase;

class CommentEnumTest extends TestCase
{

    /**
     * @throws EnumGenerationException
     */
    public function testEnumIsSingleton(): void
    {
        self::assertSame(
            Enum1::all(),
            Enum1::all()
        );

        self::assertSame(Enum1::VALUE1(), Enum1::VALUE1());
        self::assertSame(Enum1::VALUE2(), Enum1::VALUE2());
    }

    public function testInstancesAreOfStaticClass(): void
    {
        self::assertInstanceOf(Enum1::class, Enum1::VALUE1());
    }


    public function testExceptionOnInvalidValue(): void
    {
        $this->expectException(ValueNotInEnumException::class);
        Enum1::DOES_NOT_EXIST();
    }

    /**
     * @throws EnumGenerationException
     */
    public function testExceptionNoCommentOnAll(): void
    {
        $this->expectException(EnumGenerationException::class);
        NoComment::all();
    }

    public function testExceptionNoCommentOneValue(): void
    {
        $this->expectException(EnumGenerationException::class);
        NoComment::singleValue();
    }

    public function testExceptionOnArgumentsToEnum(): void
    {
        $this->expectException(\LogicException::class);
        Enum1::VALUE1('yo');
    }

    public function testGetName(): void
    {
        self::assertSame('VALUE2', Enum1::VALUE2()->getName());
    }

    public function testDisallowOfSerialization(): void
    {
        $this->expectException(\LogicException::class);
        serialize(Enum1::VALUE1());
    }

    public function testDisallowOfClone(): void
    {
        $this->expectException(\LogicException::class);
        clone Enum1::VALUE1();
    }

    public function testDisallowOfUnserialization(): void
    {
        $string = 'O:42:"Philiagus\\Enum\\Test\\Mock\\CommentEnum\\Enum1":1:{s:32:"' . "\0" . 'Philiagus\\Enum\\CommentEnum' . "\0" . 'name";s:6:"VALUE1";}';
        $this->expectException(\LogicException::class);
        $className = Enum1::class;
        unserialize($string);
    }

    public function testStringCastingReturnsName(): void
    {
        self::assertSame('VALUE1', (string) Enum1::VALUE1());
    }

    public function testCommentEnumIsNoValidEnumClassAll(): void
    {
        $this->expectException(\LogicException::class);
        CommentEnum::all();
    }

    public function testCommentEnumIsNoValidEnumClassSingleValue(): void
    {
        $this->expectException(\LogicException::class);
        CommentEnum::VALUE();
    }

    public function testThatItBlocksDuplicates(): void
    {
        $this->expectException(EnumGenerationException::class);
        Duplicates::DUPLICATE();
    }

    public function testThatItBlocksInvalidDefinitions(): void
    {
        $this->expectException(EnumGenerationException::class);
        Invalid::DUPLICATE();
    }

    public function testThatItBlocksOverwrite(): void
    {
        $this->expectException(EnumGenerationException::class);
        Overwrite::VALUE1();
    }

    public function testExceptionOnSetOfProperty(): void
    {
        $this->expectException(LogicException::class);
        Enum1::VALUE1()->nope = 'error';
    }

    public function testExtendingEnums() {
        self::assertSame(
            [
                Enum1_2::VALUE3(),
                Enum1::VALUE1(),
                Enum1::VALUE2(),
            ],
            Enum1_2::all()
        );

        self::assertSame(Enum1_2::VALUE1(), Enum1::VALUE1());
    }

}
