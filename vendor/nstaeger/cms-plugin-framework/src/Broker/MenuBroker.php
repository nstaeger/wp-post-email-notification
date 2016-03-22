<?php

namespace Nstaeger\CmsPluginFramework\Broker;

use Nstaeger\CmsPluginFramework\Menu\MenuItem;

interface MenuBroker
{
    /**
     * Register a new menu item in the administration menu.
     *
     * @param string $title The title of the entry
     * @return MenuItem
     */
    function registerAdminMenuItem($title);
}
