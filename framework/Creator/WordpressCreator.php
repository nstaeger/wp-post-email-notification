<?php

namespace Nstaeger\Framework\Creator;

use Nstaeger\Framework\Broker\AssetBroker;
use Nstaeger\Framework\Broker\DatabaseBroker;
use Nstaeger\Framework\Broker\MenuBroker;
use Nstaeger\Framework\Broker\RestBroker;
use Nstaeger\Framework\Broker\Wordpress\WordpressAssetBroker;
use Nstaeger\Framework\Broker\Wordpress\WordpressDatabaseBroker;
use Nstaeger\Framework\Broker\Wordpress\WordpressMenuBroker;
use Nstaeger\Framework\Broker\Wordpress\WordpressRestBroker;
use Nstaeger\Framework\Plugin;

class WordpressCreator implements Creator
{
    public function build(Plugin $plugin)
    {
        $plugin->singleton(AssetBroker::class, WordpressAssetBroker::class);
        $plugin->singleton(DatabaseBroker::class, WordpressDatabaseBroker::class);
        $plugin->singleton(MenuBroker::class, WordpressMenuBroker::class);
        $plugin->singleton(RestBroker::class, WordpressRestBroker::class);
    }
}
