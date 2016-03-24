<?php

namespace Nstaeger\CmsPluginFramework\Creator;

use Nstaeger\CmsPluginFramework\Broker\AssetBroker;
use Nstaeger\CmsPluginFramework\Broker\DatabaseBroker;
use Nstaeger\CmsPluginFramework\Broker\EventBroker;
use Nstaeger\CmsPluginFramework\Broker\MenuBroker;
use Nstaeger\CmsPluginFramework\Broker\OptionBroker;
use Nstaeger\CmsPluginFramework\Broker\PermissionBroker;
use Nstaeger\CmsPluginFramework\Broker\RestBroker;
use Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressAssetBroker;
use Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressDatabaseBroker;
use Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressEventBroker;
use Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressMenuBroker;
use Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressOptionsBroker;
use Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressPermissionBroker;
use Nstaeger\CmsPluginFramework\Broker\Wordpress\WordpressRestBroker;
use Nstaeger\CmsPluginFramework\Plugin;

class WordpressCreator implements Creator
{
    public function build(Plugin $plugin)
    {
        $plugin->singleton(AssetBroker::class, WordpressAssetBroker::class);
        $plugin->singleton(DatabaseBroker::class, WordpressDatabaseBroker::class);
        $plugin->singleton(EventBroker::class, WordpressEventBroker::class);
        $plugin->singleton(MenuBroker::class, WordpressMenuBroker::class);
        $plugin->singleton(PermissionBroker::class, WordpressPermissionBroker::class);
        $plugin->singleton(OptionBroker::class, WordpressOptionsBroker::class);
        $plugin->singleton(RestBroker::class, WordpressRestBroker::class);
    }
}
