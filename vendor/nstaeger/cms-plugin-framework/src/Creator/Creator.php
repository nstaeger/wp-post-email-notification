<?php

namespace Nstaeger\CmsPluginFramework\Creator;

use Nstaeger\CmsPluginFramework\Plugin;

interface Creator
{
    /**
     * Bind the concrete brokers for the system to the plugin.
     *
     * @param Plugin $plugin
     */
    public function build(Plugin $plugin);
}
