<?php

namespace Nstaeger\Framework\Broker;

interface AssetBroker
{
    /**
     * @param string $asset
     */
    function addAdminAsset($asset);
    /**
     * @param string $asset
     */
    function addAsset($asset);
}
