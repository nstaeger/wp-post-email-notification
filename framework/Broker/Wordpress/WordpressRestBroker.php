<?php

namespace Nstaeger\Framework\Broker\Wordpress;

use Nstaeger\Framework\Broker\RestBroker;
use Nstaeger\Framework\Configuration;
use Nstaeger\Framework\Http\Kernel;

class WordpressRestBroker implements RestBroker
{
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var string
     */
    private $prefix;

    public function __construct(Configuration $config, Kernel $kernel)
    {
        $this->kernel = $kernel;
        $this->prefix = $config->getRestPrefix();
    }

    public function registerEndpoint($route, $methods, $action)
    {
        $function = 'wp_ajax_' . $this->prefix . '_' . $route . '_' . strtolower($methods);

        add_action($function, function () use ($action) {
            $response = $this->kernel->handleRequest($action);
            $response->sendContent();
            die();
        });
    }
}
