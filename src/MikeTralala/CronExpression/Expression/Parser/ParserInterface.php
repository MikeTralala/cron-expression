<?php

namespace MikeTralala\CronExpression\Expression\Parser;

use MikeTralala\CronExpression\Expression\Range;

interface ParserInterface
{
    const WILDCARD = '*';

    /**
     * ParserInterface constructor.
     *
     * @param Range $range
     */
    public function __construct(Range $range);

    /**
     * @param string $chunk
     *
     * @return array
     */
    public function parse($chunk);

    /**
     * @param string $chunk
     *
     * @return int
     */
    public function satisfies($chunk);
}
