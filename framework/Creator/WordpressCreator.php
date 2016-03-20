<?php

namespace Nstaeger\Framework\Creator;

use Nstaeger\Framework\Broker\AssetBroker;
use Nstaeger\Framework\Broker\DatabaseBroker;
use Nstaeger\Framework\Broker\MenuBroker;
use Nstaeger\Framework\Broker\Wordpress\WordpressAssetBroker;
use Nstaeger\Framework\Broker\Wordpress\WordpressDatabaseBroker;
use Nstaeger\Framework\Broker\Wordpress\WordpressMenuBroker;
use Nstaeger\Framework\Plugin;

class WordpressCreator implements Creator
{
    public function build(Plugin $plugin)
    {
        $plugin->bind(AssetBroker::class, WordpressAssetBroker::class);
        $plugin->bind(DatabaseBroker::class, WordpressDatabaseBroker::class);
        $plugin->bind(MenuBroker::class, WordpressMenuBroker::class);
    }
}
