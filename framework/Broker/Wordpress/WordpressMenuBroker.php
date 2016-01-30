<?php

namespace Nstaeger\Framework\Broker\Wordpress;

use Nstaeger\Framework\Broker\MenuBroker;
use Nstaeger\Framework\Http\Kernel;
use Nstaeger\Framework\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class WordpressMenuBroker implements MenuBroker
{
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var array
     */
    private $menuItems;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
        $this->menuItems = array();

        add_action('admin_menu', function () {
            $this->registerItems();
        });
    }

    public function registerAdminMenuItem($title, $action, $capability = 'manage_options')
    {
        $this->menuItems[Str::snake($title)] = [
            'title'      => $title,
            'action'     => $action,
            'capability' => $capability
        ];
    }

    /**
     * Register the menu items in the system
     */
    private function registerItems()
    {
        foreach ($this->menuItems as $slug => $menuItem) {
            add_menu_page(
                $menuItem['title'],
                $menuItem['title'],
                $menuItem['capability'],
                $slug,
                function () use ($slug) {
                    $this->handlePageCall($slug);
                }
            );
        }
    }

    /**
     * Handle a page call, executed when the page is being accessed.
     *
     * @param string $slug the slug of the menu item
     */
    private function handlePageCall($slug)
    {
        $controller = $this->menuItems[$slug]['action'];
        $request = Request::createFromGlobals();

        $response = $this->kernel->handleRequest($request, $controller);

        $response->sendContent();
    }
}
