<?php

namespace Nstaeger\Framework\Creator;

use Nstaeger\Framework\Broker\DatabaseBroker;
use Nstaeger\Framework\Broker\MenuBroker;
use Nstaeger\Framework\Broker\Wordpress\WordpressDatabaseBroker;
use Nstaeger\Framework\Broker\Wordpress\WordpressMenuBroker;
use Nstaeger\Framework\Http\Kernel;

class WordpressCreator implements Creator
{
    public function getDatabaseBroker()
    {
        return new WordpressDatabaseBroker();
    }

    public function getMenuBroker(Kernel $kernel)
    {
        return new WordpressMenuBroker($kernel);
    }
}
