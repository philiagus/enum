<?php
declare(strict_types=1);

namespace Philiagus\Enum\Test;

use Philiagus\Enum\CommentValuesEnum;
use Philiagus\Enum\Exception\EnumGenerationException;
use Philiagus\Enum\Exception\ValueNotInEnumException;
use Philiagus\Enum\Test\Mock\CommentValuesEnum\Duplicates;
use Philiagus\Enum\Test\Mock\CommentValuesEnum\Enum1;
use Philiagus\Enum\Test\Mock\CommentValuesEnum\Enum1_2;
use Philiagus\Enum\Test\Mock\CommentValuesEnum\InvalidComment;
use Philiagus\Enum\Test\Mock\CommentValuesEnum\InvalidJson;
use Philiagus\Enum\Test\Mock\CommentValuesEnum\NoComment;
use Philiagus\Enum\Test\Mock\CommentValuesEnum\Overwrite;
use PHPUnit\Framework\TestCase;

class CommentValuesEnumTest extends TestCase
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
        $string = 'O:48:"Philiagus\\Enum\\Test\\Mock\\CommentValuesEnum\\Enum1":2:{s:38:"' . "\0" . 'Philiagus\\Enum\\CommentValuesEnum' . "\0" . 'name";s:6:"VALUE1";s:40:"' . "\0" . 'Philiagus\\Enum\\CommentValuesEnum' . "\0" . 'values";a:2:{s:1:"v";i:1;s:6:"hidden";s:7:"hidden1";}}';
        $this->expectException(\LogicException::class);
        unserialize($string);
    }

    public function testStringCastingReturnsName(): void
    {
        self::assertSame('VALUE1', (string) Enum1::VALUE1());
    }

    public function testCommentValuesEnumIsNoValidEnumClassAll(): void
    {
        $this->expectException(\LogicException::class);
        CommentValuesEnum::all();
    }

    public function testCommentValuesEnumIsNoValidEnumClassSingleValue(): void
    {
        $this->expectException(\LogicException::class);
        CommentValuesEnum::VALUE();
    }

    public function testThatItBlocksDuplicates(): void
    {
        $this->expectException(EnumGenerationException::class);
        Duplicates::DUPLICATE();
    }

    public function testThatItBlocksInvalidDefinitions(): void
    {
        $this->expectException(EnumGenerationException::class);
        InvalidComment::invalid();
    }

    public function testThatItBlocksInvalidJSON(): void
    {
        $this->expectException(EnumGenerationException::class);
        InvalidJson::VALUE();
    }

    public function testPropertyAccess(): void
    {
        self::assertTrue(Enum1::VALUE1()->hasValue('v'));
        self::assertFalse(Enum1::VALUE1()->hasValue('nope'));
        self::assertSame(1, Enum1::VALUE1()->v);
        self::assertSame(2, Enum1::VALUE2()->v);
        self::assertSame('hidden1', Enum1::VALUE1()->getHidden());
        self::assertSame('hidden2', Enum1::VALUE2()->getHidden());
        self::assertSame('hidden1', Enum1_2::VALUE1()->getHidden());
        self::assertSame('hidden2', Enum1_2::VALUE2()->getHidden());
        self::assertNull(Enum1_2::VALUE3()->getHidden());
    }

    public function testThatItBlocksOverwrite(): void
    {
        $this->expectException(EnumGenerationException::class);
        Overwrite::VALUE1();
    }

    public function testBlockOfNotExposedProperty(): void
    {
        $value = Enum1::VALUE1();
        $this->expectException(\LogicException::class);
        $value->hidden;
    }

    public function testExceptionOnSetOfProperty(): void
    {
        $this->expectException(\LogicException::class);
        Enum1::VALUE1()->v = 'error';
    }

}
