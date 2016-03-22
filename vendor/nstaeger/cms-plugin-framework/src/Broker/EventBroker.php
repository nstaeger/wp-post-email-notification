<?php

namespace Nstaeger\CmsPluginFramework\Broker;

use Nstaeger\CmsPluginFramework\Event\EventDispatcher;

interface EventBroker
{
    /**
     * Prepare to fire all common events on the dispatcher.
     *
     * @param EventDispatcher $dispatcher
     */
    function fireAll(EventDispatcher $dispatcher);
}
