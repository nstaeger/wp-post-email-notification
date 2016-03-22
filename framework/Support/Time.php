<?php

namespace Nstaeger\Framework\Support;

class Time
{
    const SQL_FORMAT = 'Y-m-d G:i:s';

    /**
     * @var int
     */
    private $timestamp;

    public static function now()
    {
        return new Time();
    }

    private function __construct()
    {
        $this->timestamp = time();
    }

    public function asSqlTimestamp()
    {
        return date(self::SQL_FORMAT, $this->timestamp);
    }

    public function plusMinutes($minutes)
    {
        if (is_int($minutes)) {
            $this->timestamp += $minutes * 60;
        }

        return $this;
    }
}
