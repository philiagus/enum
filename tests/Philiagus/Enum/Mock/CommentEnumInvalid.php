<?php
declare(strict_types=1);

namespace Philiagus\Test\Enum\Mock;

use Philiagus\Enum\CommentEnum;

/**
 * Class CommentEnum1
 *
 * @package Philiagus\test\Enum\Mock
 * @method static invalid
 */
class CommentEnumInvalid extends CommentEnum
{

    public function index(): int
    {
        return parent::getIndex();
    }
}