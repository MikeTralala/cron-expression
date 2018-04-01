<?php

namespace MikeTralala\CronExpression\Expression;

use MikeTralala\CronExpression\Exception\ExpressionException;
use MikeTralala\CronExpression\Expression\Parser\Parser;

class Expression
{
    const YEARLY   = '0 0 1 1 *';
    const ANNUALLY = '0 0 1 1 *';
    const MONTHLY  = '0 0 1 * *';
    const WEEKLY   = '0 0 * * 0';
    const DAILY    = '0 0 * * *';
    const HOURLY   = '0 * * * *';
    const MINUTELY = '* * * * *';

    /**
     * @var string
     */
    private $expression;

    /**
     * Expression constructor.
     *
     * @param string $expression
     */
    public function __construct($expression)
    {
        $this->expression = $expression;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->expression;
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function parse()
    {
        $chunks = preg_split('/\s/', $this->expression, -1, PREG_SPLIT_NO_EMPTY);

        if (5 !== count($chunks)) {
            throw ExpressionException::createInvalidChunksCountException($chunks);
        }

        $values = [];

        foreach ($chunks as $i => $chunk) {
            $parser = new Parser($this->getAllowedRange($i));

            if (! $parser->satisfies($chunk)) {
                throw ExpressionException::createUnparsableChunkException($chunk);
            }

            $values[$this->getNameForPosition($i)] = $parser->parse($chunk);
        }

        return $values;
    }

    /**
     * @param \DateTime|null $dateTime
     *
     * @return bool
     */
    public function isDue(\DateTime $dateTime = null)
    {
        if (null === $dateTime) {
            $dateTime = new \DateTime();
        }

        $current = [
            'minute'       => (int) $dateTime->format('i'),
            'hour'         => (int) $dateTime->format('H'),
            'day_of_month' => (int) $dateTime->format('d'),
            'month'        => (int) $dateTime->format('m'),
            'day_of_week'  => (int) $dateTime->format('w'),
        ];

        $values = $this->parse();

        foreach ($current as $type => $value) {
            if (! in_array($value, $values[$type])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param int $position
     *
     * @return string
     *
     * @throws ExpressionException
     */
    private function getNameForPosition($position)
    {
        switch ($position) {
            case 0:
                return 'minute';
            case 1:
                return 'hour';
            case 2:
                return 'day_of_month';
            case 3:
                return 'month';
            case 4:
                return 'day_of_week';
        }

        throw ExpressionException::createInvalidPositionException($position);
    }

    /**
     * @param int $position
     *
     * @return Range
     *
     * @throws ExpressionException
     */
    private function getAllowedRange($position)
    {
        switch ($position) {
            case 0:
                return new Range(0, 59);
            case 1:
                return new Range(0, 23);
            case 2:
                return new Range(1, 31);
            case 3:
                return new Range(1, 12);
            case 4:
                return new Range(0, 6);
        }

        throw ExpressionException::createInvalidPositionException($position);
    }
}
