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

namespace Philiagus\Enum\Test\Mock;

use Philiagus\Enum\CommentEnum;

/**
 * Class CommentEnum1
 *
 * @package Philiagus\test\Enum\Mock
 * @method static CommentEnum1 VALUE1
 * @method static CommentEnum1 VALUE2
 */
class CommentEnum1 extends CommentEnum
{

    public function index(): int
    {
        return parent::getIndex();
    }
}