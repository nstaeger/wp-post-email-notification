<?php

namespace Nstaeger\CmsPluginFramework\Broker\Wordpress;

use Nstaeger\CmsPluginFramework\Broker\RestBroker;
use Nstaeger\CmsPluginFramework\Configuration;
use Nstaeger\CmsPluginFramework\Http\Kernel;
use Nstaeger\CmsPluginFramework\Item\RestEndpointItem;

/**
 * TODO what about access control?
 */
class WordpressRestBroker implements RestBroker
{
    /**
     * @var RestEndpointItem[]
     */
    private $endpoints;
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var string
     */
    private $prefix;

    public function __construct(Kernel $kernel, Configuration $config)
    {
        $this->endpoints = array();
        $this->kernel = $kernel;
        $this->prefix = $config->getRestPrefix();

        add_action(
            'init',
            function () {
                $this->loadEndpoints();
            }
        );
    }

    /**
     * @param string $route
     * @return RestEndpointItem
     */
    public function delete($route)
    {
        return $this->registerEndpoint('DELETE', $route);
    }

    /**
     * @param string $route
     * @return RestEndpointItem
     */
    public function get($route)
    {
        return $this->registerEndpoint('GET', $route);
    }

    /**
     * @param string $route
     * @return RestEndpointItem
     */
    public function post($route)
    {
        return $this->registerEndpoint('POST', $route);
    }

    /**
     * @param string $route
     * @return RestEndpointItem
     */
    public function put($route)
    {
        return $this->registerEndpoint('PUT', $route);
    }

    /**
     * @param string $method
     * @param string $route
     * @return RestEndpointItem
     */
    public function registerEndpoint($method, $route)
    {
        $endpoint = new RestEndpointItem($method, $route);
        $this->endpoints[] = $endpoint;

        return $endpoint;
    }

    private function loadEndpoints()
    {
        foreach ($this->endpoints as $endpoint) {
            $wordpress_pre = 'wp_ajax';

            $function = [
                $wordpress_pre,
                $this->prefix,
                $endpoint->getRoute(),
                strtolower($endpoint->getMethod())
            ];

            add_action(
                implode('_', $function),
                function () use ($endpoint) {
                    $response = $this->kernel->handleRequest($endpoint->getAction());
                    $response->sendContent();
                    die();
                }
            );

            if ($endpoint->getEnabledForUnauthorized()) {
                $function = [
                    $wordpress_pre,
                    'nopriv',
                    $this->prefix,
                    $endpoint->getRoute(),
                    strtolower($endpoint->getMethod())
                ];

                add_action(
                    implode('_', $function),
                    function () use ($endpoint) {
                        $response = $this->kernel->handleRequest($endpoint->getAction());
                        $response->sendContent();
                        die();
                    }
                );
            }
        }
    }
}
