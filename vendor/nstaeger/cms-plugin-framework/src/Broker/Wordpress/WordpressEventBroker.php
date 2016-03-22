<?php

namespace Nstaeger\CmsPluginFramework\Broker\Wordpress;

use Nstaeger\CmsPluginFramework\Broker\EventBroker;
use Nstaeger\CmsPluginFramework\Configuration;
use Nstaeger\CmsPluginFramework\Event\EventDispatcher;

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

        add_action('init', function() use ($dispatcher) { $dispatcher->fire('init'); });
        add_action('wp_loaded', function() use ($dispatcher) { $dispatcher->fire('loaded'); });
    }
}
