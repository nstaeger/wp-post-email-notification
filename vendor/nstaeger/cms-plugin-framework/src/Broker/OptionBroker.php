<?php

namespace Nstaeger\CmsPluginFramework\Broker;

interface OptionBroker
{
    /**
     * Store a value of an option.
     *
     * @param string $option unique name of the option
     * @param mixed  $value  data to store under this option
     */
    function store($option, $value);

    /**
     * Retrive the value of an option.
     *
     * @param string $option unique name of the option
     * @return mixed
     */
    function get($option);
}
