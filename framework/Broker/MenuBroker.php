<?php

namespace Nstaeger\Framework\Broker;

interface MenuBroker
{
    /**
     * Register a new menu item in the administration menu.
     *
     * @param string $title      The title of the entry
     * @param mixed  $action     The controller and function or callable to be used, separated by @
     * @param string $capability The capability/permission that is needed to show the menu item
     */
    function registerAdminMenuItem($title, $action, $capability = '');
}
