<?php

namespace Nstaeger\CmsPluginFramework\Broker;

interface EventBroker
{
    /**
     * Prepare to fire all common events on the dispatcher.
     */
    function fireAll();
}
