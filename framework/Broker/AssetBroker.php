<?php

namespace Nstaeger\Framework\Broker;

interface AssetBroker
{
    /**
     * @param string $asset
     */
    function addAdminAsset($asset);

    /**
     * @param string[] $assets
     */
    function addAdminAssets($assets);

    /**
     * @param string $asset
     */
    function addAsset($asset);
}
