<?php

namespace Nstaeger\CmsPluginFramework\Broker\Wordpress;

use Nstaeger\CmsPluginFramework\Broker\AssetBroker;
use Nstaeger\CmsPluginFramework\Broker\MenuBroker;
use Nstaeger\CmsPluginFramework\Http\Kernel;
use Nstaeger\CmsPluginFramework\Item\MenuItem;

class WordpressMenuBroker implements MenuBroker
{
    /**
     * @var AssetBroker
     */
    private $assetBroker;

    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var MenuItem[]
     */
    private $menuItems;

    public function __construct(AssetBroker $assetBroker, Kernel $kernel)
    {
        $this->assetBroker = $assetBroker;
        $this->kernel = $kernel;
        $this->menuItems = array();

        add_action(
            'admin_menu',
            function () {
                $this->registerItems();
            }
        );
    }

    public function registerAdminMenuItem($title)
    {
        $menuItemBuilder = new MenuItem($title);
        $menuItemBuilder->withCapability('manage_options');

        $this->menuItems[] = $menuItemBuilder;

        return $menuItemBuilder;
    }

    /**
     * Register the menu items in the system
     */
    private function registerItems()
    {
        foreach ($this->menuItems as $menuItem) {
            if (!empty($menuItem->getAssets()))
            {
                $this->assetBroker->addAdminAssets($menuItem->getAssets());
            }

            add_menu_page(
                $menuItem->getTitle(),
                $menuItem->getTitle(),
                $menuItem->getCapability(),
                $menuItem->getSlug(),
                function () use ($menuItem) {
                    $this->handlePageCall($menuItem);
                }
            );
        }
    }

    /**
     * Handle a page call, executed when the page is being accessed.
     *
     * @param MenuItem $menuItem the menu item
     */
    private function handlePageCall(MenuItem $menuItem)
    {
        $response = $this->kernel->handleRequest($menuItem->getAction());
        $response->sendContent();
    }
}
