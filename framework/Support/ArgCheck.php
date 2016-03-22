<?php

namespace Nstaeger\Framework\Support;

class ArgCheck
{
    public static function isInt($arg)
    {
        if (!is_int($arg) && !is_numeric($arg)) {
            throw new \InvalidArgumentException("Expected an Integer but was: " . $arg);
        }
    }
}
