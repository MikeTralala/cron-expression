<?php

namespace Tests\MikeTralala\CronExpression\Exception;

use MikeTralala\CronExpression\Exception\ExpressionException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \MikeTralala\CronExpression\Exception\ExpressionException
 */
class ExpressionExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function test_construct()
    {
        $exception = new ExpressionException();

        $this->assertInstanceOf(ExpressionException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);
    }

    /**
     * @covers ::createInvalidPositionException
     * @covers ::__construct
     */
    public function test_create_invalid_position_exception()
    {
        $exception = ExpressionException::createInvalidPositionException(0);

        $this->assertInstanceOf(ExpressionException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);

        $this->assertContains('"0"', $exception->getMessage());
    }

    /**
     * @covers ::createUnparsableChunkException
     * @covers ::__construct
     */
    public function test_create_unparsable_chunk_exception()
    {
        $exception = ExpressionException::createUnparsableChunkException('123');

        $this->assertInstanceOf(ExpressionException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);

        $this->assertContains('"123"', $exception->getMessage());
    }

    /**
     * @covers ::createInvalidChunksCountException
     * @covers ::__construct
     */
    public function test_create_invalid_chunk_count_exception()
    {
        $exception = ExpressionException::createInvalidChunksCountException(['*', '*']);

        $this->assertInstanceOf(ExpressionException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);

        $this->assertContains('2', $exception->getMessage());
        $this->assertContains('"*, *"', $exception->getMessage());
    }
}
