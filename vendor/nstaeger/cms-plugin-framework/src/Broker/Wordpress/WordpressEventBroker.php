<?php

namespace Nstaeger\CmsPluginFramework\Broker\Wordpress;

use Nstaeger\CmsPluginFramework\Broker\EventBroker;
use Nstaeger\CmsPluginFramework\Configuration;
use Nstaeger\CmsPluginFramework\Event\EventDispatcher;

class WordpressEventBroker implements EventBroker
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var string
     */
    private $mainPluginFile;

    public function __construct(Configuration $configuration, EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->mainPluginFile = $configuration->getMainPluginFile();
    }

    function fireAll()
    {
        register_activation_hook(
            $this->mainPluginFile,
            function () {
                $this->dispatcher->fire('activate');
            }
        );

        register_deactivation_hook(
            $this->mainPluginFile,
            function () {
                $this->dispatcher->fire('deactivate');
            }
        );

        add_action('init', function() { $this->dispatcher->fire('init'); });
        add_action('wp_loaded', function() { $this->dispatcher->fire('loaded'); });
    }
}
