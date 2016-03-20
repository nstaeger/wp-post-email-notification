<?php

namespace Nstaeger\Framework\Creator;

use Nstaeger\Framework\Plugin;

interface Creator
{
    /**
     * Bind the concrete brokers for the system to the plugin.
     *
     * @param Plugin $plugin
     */
    public function build(Plugin $plugin);
}
