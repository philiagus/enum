<?php
declare(strict_types=1);

namespace Philiagus\Test\Enum;

use Philiagus\Enum\CommentEnum;
use Philiagus\Enum\Exception\EnumGenerationException;
use Philiagus\Enum\Exception\ValueNotInEnumException;
use Philiagus\Test\Enum\Mock\CommentEnum1;
use Philiagus\Test\Enum\Mock\CommentEnumDuplicates;
use Philiagus\Test\Enum\Mock\CommentEnumInvalid;
use Philiagus\Test\Enum\Mock\CommentEnumNoComment;
use PHPUnit\Framework\TestCase;

class CommentEnumTest extends TestCase
{

    /**
     * @throws EnumGenerationException
     */
    public function testEnumIsSingleton(): void
    {
        self::assertSame(
            CommentEnum1::all(),
            CommentEnum1::all()
        );

        self::assertSame(CommentEnum1::VALUE1(), CommentEnum1::VALUE1());
        self::assertSame(CommentEnum1::VALUE2(), CommentEnum1::VALUE2());
    }

    public function testInstancesAreOfStaticClass(): void
    {
        self::assertInstanceOf(CommentEnum1::class, CommentEnum1::VALUE1());
    }


    public function testExceptionOnInvalidValue(): void
    {
        self::expectException(ValueNotInEnumException::class);
        CommentEnum1::DOES_NOT_EXIST();
    }

    /**
     * @throws EnumGenerationException
     */
    public function testExceptionNoCommentOnAll(): void
    {
        self::expectException(EnumGenerationException::class);
        CommentEnumNoComment::all();
    }

    public function testExceptionNoCommentOneValue(): void
    {
        self::expectException(EnumGenerationException::class);
        CommentEnumNoComment::singleValue();
    }

    public function testExceptionOnArgumentsToEnum(): void
    {
        self::expectException(\LogicException::class);
        CommentEnum1::VALUE1('yo');
    }

    public function testGetName(): void
    {
        self::assertSame('VALUE2', CommentEnum1::VALUE2()->getName());
    }

    public function testDisallowOfSerialization(): void
    {
        self::expectException(\LogicException::class);
        serialize(CommentEnum1::VALUE1());
    }

    public function testDisallowOfClone(): void
    {
        self::expectException(\LogicException::class);
        clone CommentEnum1::VALUE1();
    }

    public function testDisallowOfUnserialization(): void
    {
        self::expectException(\LogicException::class);
        unserialize('C:37:"Philiagus\Test\Enum\Mock\CommentEnum1":0:{}');
    }

    public function testStringCastingReturnsName(): void
    {
        self::assertSame('VALUE1', (string) CommentEnum1::VALUE1());
    }

    public function testIndexGeneration(): void
    {
        self::assertSame(0, CommentEnum1::VALUE1()->index());
        self::assertSame(1, CommentEnum1::VALUE2()->index());
    }

    public function testCommentEnumIsNoValidEnumClassAll(): void
    {
        self::expectException(\LogicException::class);
        CommentEnum::all();
    }

    public function testCommentEnumIsNoValidEnumClassSingleValue(): void
    {
        self::expectException(\LogicException::class);
        CommentEnum::VALUE();
    }

    public function testThatItBlocksDuplicates(): void
    {
        self::expectException(EnumGenerationException::class);
        CommentEnumDuplicates::DUPLICATE();
    }

    public function testThatItBlocksInvalidDefinitions(): void
    {
        self::expectException(EnumGenerationException::class);
        CommentEnumInvalid::DUPLICATE();
    }

}