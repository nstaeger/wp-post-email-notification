<?php

namespace Nstaeger\Framework\Broker\Wordpress;

use Nstaeger\Framework\Broker\EventBroker;
use Nstaeger\Framework\Configuration;
use Nstaeger\Framework\Event\EventDispatcher;

class WordpressEventBroker implements EventBroker
{
    private $mainPluginFile;

    public function __construct(Configuration $configuration)
    {
        $this->mainPluginFile = $configuration->getMainPluginFile();
    }

    function fireAll(EventDispatcher $dispatcher)
    {
        register_activation_hook(
            $this->mainPluginFile,
            function () use ($dispatcher) {
                $dispatcher->fire('activate');
            }
        );

        register_deactivation_hook(
            $this->mainPluginFile,
            function () use ($dispatcher) {
                $dispatcher->fire('deactivate');
            }
        );
    }
}
