<?php

namespace Nstaeger\CmsPluginFramework\Creator;

use Nstaeger\CmsPluginFramework\Plugin;

class WordpressCreator implements Creator
{
    public function build(Plugin $plugin)
    {
        $plugin->singleton(
            'Nstaeger\CmsPluginFramework\Broker\AssetBroker',
            'Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressAssetBroker'
        );
        $plugin->singleton(
            'Nstaeger\CmsPluginFramework\Broker\DatabaseBroker',
            'Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressDatabaseBroker'
        );
        $plugin->singleton(
            'Nstaeger\CmsPluginFramework\Broker\EventBroker',
            'Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressEventBroker'
        );
        $plugin->singleton(
            'Nstaeger\CmsPluginFramework\Broker\MenuBroker',
            'Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressMenuBroker'
        );
        $plugin->singleton(
            'Nstaeger\CmsPluginFramework\Broker\PermissionBroker',
            'Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressPermissionBroker'
        );
        $plugin->singleton(
            'Nstaeger\CmsPluginFramework\Broker\OptionBroker',
            'Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressOptionsBroker'
        );
        $plugin->singleton(
            'Nstaeger\CmsPluginFramework\Broker\RestBroker',
            'Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressRestBroker'
        );
    }
}
