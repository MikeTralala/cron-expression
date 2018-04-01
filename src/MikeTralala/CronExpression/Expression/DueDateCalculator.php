<?php

namespace MikeTralala\CronExpression\Expression;

class DueDateCalculator
{
    const TYPE_FUTURE = 'future';
    const TYPE_PAST   = 'past';

    /**
     * @var int
     */
    private $maxIterations;

    /**
     * DueDateCalculator constructor.
     *
     * @param $maxIterations
     */
    public function __construct($maxIterations = 2500)
    {
        $this->maxIterations = $maxIterations;
    }

    /**
     * @param string         $type
     * @param Expression     $expression
     * @param int            $limit
     * @param \DateTime|null $fromDateTime
     *
     * @return array|\DateTime[]
     */
    public function getDueDates($type, Expression $expression, $limit = 1, \DateTime $fromDateTime = null)
    {
        if (null === $fromDateTime) {
            $fromDateTime = new \DateTime();
        }

        $dateTime = clone $fromDateTime;
        $parsed   = $expression->parse();
        $dueDates = [];

        $i = 0;
        while (count($dueDates) < $limit) {
            $this->getPossibleDueDate($type, $dateTime, $parsed);

            if ($expression->isDue($dateTime)) {
                $dueDates[$dateTime->getTimestamp()] = clone $dateTime;
            }

            if (++$i > $this->maxIterations) {
                throw new \RuntimeException(sprintf('Maximum amount of iterations "%s" encountered', $this->maxIterations));
            }
        }

        ksort($dueDates);

        return array_values($dueDates);
    }

    /**
     * @param string    $type
     * @param \DateTime $dateTime
     * @param array     $parsed
     *
     * @return \DateTime
     *
     * @throws \InvalidArgumentException
     */
    private function getPossibleDueDate($type, \DateTime $dateTime, array $parsed)
    {
        if (! in_array($type, [self::TYPE_FUTURE, self::TYPE_PAST])) {
            throw new \InvalidArgumentException(sprintf('The provided type "%s" is invalid', $type));
        }

        $modifier = self::TYPE_FUTURE === $type ? '+' : '-';

        if (1 === count($parsed['minute']) && 1 === count($parsed['hour'])) {
            $dateTime->setTime($parsed['hour'][0], $parsed['minute'][0]);
            $dateTime->modify("{$modifier} 1 day");
        } elseif (1 === count($parsed['minute'])) {
            $dateTime->setTime($dateTime->format('H'), $parsed['minute'][0]);
            $dateTime->modify("{$modifier} 1 hour");
        } else {
            $dateTime->modify("{$modifier} 1 minute");
        }

        return $dateTime;
    }
}
