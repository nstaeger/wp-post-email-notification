<?php

namespace Nstaeger\Framework\Broker\Wordpress;

use Nstaeger\Framework\Broker\AssetBroker;
use Nstaeger\Framework\Configuration;

class WordpressAssetBroker implements AssetBroker
{
    /**
     * @var string
     */
    private $url;

    public function __construct(Configuration $configuration)
    {
        $this->url = $configuration->getUrl();
    }

    public function addAsset($asset)
    {
        $path = $this->url . $asset;
        wp_enqueue_script($asset, $path);
    }
}
