<?php

namespace Nstaeger\CmsPluginFramework\Support;

use InvalidArgumentException;

class ArgCheck
{
    public static function isArray($arg)
    {
        if (!is_array($arg)) {
            throw new InvalidArgumentException("Expected an array, but was: " . $arg);
        }
    }

    public static function isEmail($arg)
    {
        if (empty($arg) || !is_email($arg)) {
            throw new InvalidArgumentException("Expected an email, but was: " . $arg);
        }
    }

    public static function isInt($arg)
    {
        if (!is_int($arg) && !is_numeric($arg)) {
            throw new InvalidArgumentException("Expected an integer, but was: " . $arg);
        }
    }

    public static function isIp($arg)
    {
        if (empty($arg) || (!filter_var($arg, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
                && !filter_var($arg, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
        ) {
            throw new InvalidArgumentException("Expected an IP, but was " . $arg);
        }
    }

    public static function notNull($arg)
    {
        if ($arg == null) {
            throw new InvalidArgumentException("Expected null, but was " . $arg);
        }
    }
}
