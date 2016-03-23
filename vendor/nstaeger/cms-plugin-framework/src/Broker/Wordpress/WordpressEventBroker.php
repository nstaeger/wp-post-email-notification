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
    private $mainPluginFile;

    public function __construct(Configuration $configuration, EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->mainPluginFile = $configuration->getMainPluginFile();
    }

    function fireAll()
    {
        register_activation_hook(
            __FILE__,
            function () {
                $this->dispatcher->fire('activate');
            }
        );

        register_deactivation_hook(
            __FILE__,
            function () {
                $this->dispatcher->fire('deactivate');
            }
        );

        register_uninstall_hook(
            __FILE__,
            array($this, 'fireUninstall')
        );

        add_action('init', function() { $this->dispatcher->fire('init'); });
        add_action('wp_loaded', function() { $this->dispatcher->fire('loaded'); });
    }

    private function fireUninstall()
    {
        $this->dispatcher->fire('uninstall');
    }
}
