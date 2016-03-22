<?php

namespace Nstaeger\CmsPluginFramework\Support;

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
        return $this->addSeconds($minutes * 60);
    }

    public function addSeconds($seconds)
    {
        if (is_int($seconds)) {
            $this->timestamp += $seconds;
        }

        return $this;
    }
}
