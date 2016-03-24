<?php

namespace Nstaeger\CmsPluginFramework\Broker;

use Nstaeger\CmsPluginFramework\Item\RestEndpointItem;

interface RestBroker
{
    /**
     * Add a rest endpoint for DELETE requests.
     *
     * @param string $route
     * @return RestEndpointItem
     */
    function delete($route);

    /**
     * Add a rest endpoint for GET requests.
     *
     * @param string $route
     * @return RestEndpointItem
     */
    public function get($route);

    /**
     * Add a rest endpoint for POST requests.
     *
     * @param string $route
     * @return RestEndpointItem
     */
    public function post($route);

    /**
     * Add a rest endpoint for PUT requests.
     *
     * @param string $route
     * @return RestEndpointItem
     */
    public function put($route);
}
