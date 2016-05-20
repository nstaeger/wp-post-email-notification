<?php

namespace Nstaeger\CmsPluginFramework\Broker\Wordpress;

use Nstaeger\CmsPluginFramework\Item\AssetItem;
use Nstaeger\CmsPluginFramework\Broker\AssetBroker;
use Nstaeger\CmsPluginFramework\Configuration;

class WordpressAssetBroker implements AssetBroker
{
    /**
     * @var AssetItem[]
     */
    private $adminAssets;

    /**
     * @var AssetItem[]
     */
    private $assets;

    /**
     * @var string
     */
    private $urlPrefix;

    public function __construct(Configuration $configuration)
    {
        $this->adminAssets = array();
        $this->assets = array();
        $this->urlPrefix = $configuration->getUrl();

        add_action(
            'admin_enqueue_scripts',
            function ($hook) {
                $this->enqueueAdminAssets($hook);
            }
        );

        add_action(
            'wp_enqueue_scripts',
            function () {
                $this->enqueueAssets();
            }
        );
    }

    public function addAdminAsset(AssetItem $asset)
    {
        $this->adminAssets[] = $asset;
    }

    function addAdminAssets($assets)
    {
        foreach ($assets as $asset) {
            $this->addAdminAsset($asset);
        }
    }

    public function addAsset(AssetItem $asset)
    {
        $this->assets[] = $asset;
    }

    private function enqueueAdminAssets($hook)
    {
        foreach ($this->adminAssets as $asset) {
            if (!empty($asset->getHook()) && strpos($hook, $asset->getHook()) === false) {
                continue;
            }

            // TODO register script first with wp_register_script
            $path = $this->urlPrefix . $asset->getUrl();
            wp_enqueue_script($asset->getName(), $path);
        }
    }

    private function enqueueAssets()
    {
        foreach ($this->assets as $asset) {
            // TODO register script first with wp_register_script
            $path = $this->urlPrefix . $asset->getUrl();
            wp_enqueue_script($asset->getName(), $path);

            // TODO this should be solved in another way
            wp_localize_script($asset->getName(), 'ajaxurl', admin_url('admin-ajax.php'));
        }
    }
}
