<?php

namespace Nstaeger\CmsPluginFramework\Broker\Wordpress;

use Nstaeger\CmsPluginFramework\Broker\PermissionBroker;

class WordpressPermissionBroker implements PermissionBroker
{
    /**
     * Key: plugin-internal permission
     * Value: system permission
     *
     * @var array
     */
    private $mappings;

    public function __construct()
    {
        $this->mappings = array();
    }

    function has($internal)
    {
        return current_user_can($this->mappings[$internal]);
    }

    function registerPermissionMapping($internal, $system)
    {
        $this->mappings[$internal] = $system;
    }
}
