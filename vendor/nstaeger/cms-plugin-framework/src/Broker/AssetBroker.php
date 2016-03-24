<?php

namespace Nstaeger\CmsPluginFramework\Broker;

use Nstaeger\CmsPluginFramework\Item\AssetItem;

interface AssetBroker
{
    /**
     * @param AssetItem $asset
     */
    function addAdminAsset(AssetItem $asset);

    /**
     * @param AssetItem[] $assets
     */
    function addAdminAssets($assets);

    /**
     * @param AssetItem $asset
     */
    function addAsset(AssetItem $asset);
}
