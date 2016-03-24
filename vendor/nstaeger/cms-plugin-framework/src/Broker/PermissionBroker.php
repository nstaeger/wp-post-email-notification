<?php

namespace Nstaeger\CmsPluginFramework\Broker;

interface PermissionBroker
{
    /**
     * Check, whether the authenticated user has the plugin-internal permission. The plugin-internal permission might
     * need to have a registered mapping to a system permission.
     *
     * @param string $internal the plugin-internal permission
     * @return boolean TRUE if the authenticated user has the plugin-internal permission, else FALSE
     */
    function has($internal);

    /**
     * Register a permission mapping from a plugin-internal permission to a system permission. Whenever the
     * authenticated user has the system permission, he also has the plugin-internal permission.
     *
     * @param string $internal the plugin-internal permission
     * @param string $system   the system permission
     */
    function registerPermissionMapping($internal, $system);
}
