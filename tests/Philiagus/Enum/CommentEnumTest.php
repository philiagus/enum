<?php
declare(strict_types=1);

namespace Philiagus\Test\Enum;

use Philiagus\Enum\Exception\EnumGenerationException;
use Philiagus\Enum\Exception\InvalidEnumException;
use Philiagus\Test\Enum\Mock\CommentEnum1;
use Philiagus\Test\Enum\Mock\CommentEnumNoComment;
use PHPUnit\Framework\TestCase;

class CommentEnumTest extends TestCase {

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
        self::expectException(InvalidEnumException::class);
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
        self::expectException(EnumGenerationException::class);
        CommentEnum1::VALUE1('yo');
    }

    public function testGetName(): void
    {
        self::assertSame('VALUE2', CommentEnum1::VALUE2()->getName());
    }

}