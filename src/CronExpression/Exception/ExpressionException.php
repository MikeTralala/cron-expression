<?php

namespace Miketralala\CronExpression\Exception;

class ExpressionException extends \RuntimeException
{
    /**
     * @param int|string $position
     *
     * @return ExpressionException
     */
    public static function createInvalidPositionException($position)
    {
        return new self(sprintf('The position "%s" is invalid', $position));
    }

    /**
     * @param string $chunk
     *
     * @return ExpressionException
     */
    public static function createUnparsableChunkException($chunk)
    {
        return new self(sprintf('The expression chunk "%s" is not parsable', $chunk));
    }
}
