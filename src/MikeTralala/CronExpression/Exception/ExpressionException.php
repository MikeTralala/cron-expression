<?php

namespace MikeTralala\CronExpression\Exception;

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

    /**
     * @param array $chunks
     *
     * @return ExpressionException
     */
    public static function createInvalidChunksCountException(array $chunks)
    {
        return new self(sprintf('The expression should contain 5 chunks you provided %s chunks: "%s"', count($chunks), implode(', ', $chunks)));
    }
}
