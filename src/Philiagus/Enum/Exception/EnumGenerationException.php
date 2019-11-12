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

namespace Philiagus\Enum\Exception;

class EnumGenerationException extends \LogicException
{
    /**
     * @var string
     */
    private $class;

    /**
     * EnumGenerationException constructor.
     *
     * @param string $message
     * @param string $class
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, string $class, \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}