<?php

namespace Nstaeger\CmsPluginFramework\Broker;

interface OptionBroker
{
    /**
     * Delete an option.
     *
     * @param string $option unique name of the option
     */
    function delete($option);

    /**
     * Retrieve the value of an option.
     *
     * @param string $option unique name of the option
     * @return mixed
     */
    function get($option);

    /**
     * Store a value of an option.
     *
     * @param string $option unique name of the option
     * @param mixed  $value  data to store under this option
     */
    function store($option, $value);
}
