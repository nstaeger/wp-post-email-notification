<?php

namespace Nstaeger\Framework\Broker;

interface RestBroker
{
    /**
     * @param string          $route
     * @param string|array    $methods
     * @param string|callable $action
     */
    function registerEndpoint($route, $methods, $action);
}
