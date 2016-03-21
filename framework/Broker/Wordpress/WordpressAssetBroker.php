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

    public function addAdminAsset($asset)
    {
        add_action('admin_enqueue_scripts', function($hook) use ($asset) {
            // TODO allow usage of hook (if (strpos($hook, 'wp-ps-options') !== false) {...)
            $path = $this->url . $asset;
            wp_enqueue_script($asset, $path);
        });
    }

    public function addAsset($asset)
    {
        add_action('wp_enqueue_scripts', function() use ($asset) {
            $path = $this->url . $asset;
            wp_enqueue_script($asset, $path);
            // TODO solve in another way
            wp_localize_script($asset, 'ajaxurl', admin_url('admin-ajax.php'));
        });
    }
}
