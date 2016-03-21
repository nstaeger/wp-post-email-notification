<?php

namespace Nstaeger\Framework\Broker;

use Nstaeger\Framework\Event\EventDispatcher;

interface EventBroker
{
    /**
     * Prepare to fire all common events on the dispatcher.
     *
     * @param EventDispatcher $dispatcher
     */
    function fireAll(EventDispatcher $dispatcher);
}
