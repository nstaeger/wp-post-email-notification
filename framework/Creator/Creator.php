<?php

namespace Nstaeger\Framework\Creator;

use Nstaeger\Framework\Broker\DatabaseBroker;
use Nstaeger\Framework\Broker\MenuBroker;
use Nstaeger\Framework\Http\Kernel;

interface Creator
{
    /**
     * @return DatabaseBroker
     */
    public function getDatabaseBroker();

    /**
     * @param Kernel $kernel
     * @return MenuBroker
     */
    public function getMenuBroker(Kernel $kernel);
}
