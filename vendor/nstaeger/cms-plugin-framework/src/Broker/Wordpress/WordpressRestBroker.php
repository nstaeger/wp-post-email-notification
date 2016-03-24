<?php

namespace Nstaeger\CmsPluginFramework\Broker\Wordpress;

use Nstaeger\CmsPluginFramework\Broker\PermissionBroker;
use Nstaeger\CmsPluginFramework\Broker\RestBroker;
use Nstaeger\CmsPluginFramework\Configuration;
use Nstaeger\CmsPluginFramework\Http\Kernel;
use Nstaeger\CmsPluginFramework\Item\RestEndpointItem;
use Symfony\Component\HttpFoundation\Response;

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
     * @var PermissionBroker
     */
    private $permssions;

    /**
     * @var string
     */
    private $prefix;

    public function __construct(Configuration $config, Kernel $kernel, PermissionBroker $permissionBroker)
    {
        $this->endpoints = array();
        $this->kernel = $kernel;
        $this->permssions = $permissionBroker;
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

            if ($endpoint->accessibleForAuthorized()) {
                $function = [
                    $wordpress_pre,
                    $this->prefix,
                    $endpoint->getRoute(),
                    strtolower($endpoint->getMethod())
                ];

                add_action(
                    implode('_', $function),
                    function () use ($endpoint) {
                        $perm = $endpoint->getRequiredPermission();

                        if ($perm == null || ($perm != null && $this->permssions->has($perm))) {
                            $response = $this->kernel->handleRequest($endpoint->getAction());
                        }
                        else {
                            $response = new Response("Unauthorized", Response::HTTP_UNAUTHORIZED);
                        }

                        $response->send();
                        die();
                    }
                );
            }

            if ($endpoint->accessibleForUnauthorized()) {
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
