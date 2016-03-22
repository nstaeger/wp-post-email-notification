<?php

namespace Nstaeger\CmsPluginFramework\Broker;

interface RestBroker
{
    /**
     * @param string          $route
     * @param string|array    $methods
     * @param string|callable $action
     * @param boolean         $nopriv
     */
    function registerEndpoint($route, $methods, $action, $nopriv = false);
}
