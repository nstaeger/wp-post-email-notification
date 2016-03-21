<?php

namespace Nstaeger\Framework\Broker\Wordpress;

use Nstaeger\Framework\Broker\RestBroker;
use Nstaeger\Framework\Configuration;
use Nstaeger\Framework\Http\Kernel;

/**
 * TODO what about access control?
 */
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

    public function registerEndpoint($route, $methods, $action, $nopriv = false)
    {
        // TODO cleanup when working on access control

        $wordpress_pre = 'wp_ajax_';
        $function = $wordpress_pre . $this->prefix . '_' . $route . '_' . strtolower($methods);

        add_action($function, function () use ($action) {
            $response = $this->kernel->handleRequest($action);
            $response->sendContent();
            die();
        });

        if ($nopriv)
        {
            $function = $wordpress_pre . 'nopriv_' . $this->prefix . '_' . $route . '_' . strtolower($methods);

            add_action($function, function () use ($action) {
                $response = $this->kernel->handleRequest($action);
                $response->sendContent();
                die();
            });
        }
    }
}
