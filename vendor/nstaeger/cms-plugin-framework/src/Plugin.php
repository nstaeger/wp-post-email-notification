<?php

namespace Nstaeger\CmsPluginFramework;

use Illuminate\Container\Container;
use Nstaeger\CmsPluginFramework\Broker\AssetBroker;
use Nstaeger\CmsPluginFramework\Broker\MenuBroker;
use Nstaeger\CmsPluginFramework\Broker\PermissionBroker;
use Nstaeger\CmsPluginFramework\Broker\RestBroker;
use Nstaeger\CmsPluginFramework\Creator\Creator;
use Nstaeger\CmsPluginFramework\Event\EventDispatcher;
use Nstaeger\CmsPluginFramework\Templating\TemplateRenderer;
use Symfony\Component\HttpFoundation\Request;

class Plugin extends Container
{
    public function __construct(Configuration $configuration, Creator $creator)
    {
        self::setInstance($this);

        $this->instance('Nstaeger\CmsPluginFramework\Configuration', $configuration);
        $this->singleton(
            'Nstaeger\CmsPluginFramework\Event\EventDispatcher',
            'Nstaeger\CmsPluginFramework\Event\EventDispatcher'
        );
        $creator->build($this);

        // register regular events from system
        $this->make('Nstaeger\CmsPluginFramework\Broker\EventBroker')->fireAll($this->events());

        // regular request
        $this->singleton(
            'Symfony\Component\HttpFoundation\Request',
            function () {
                return Request::createFromGlobals();
            }
        );

        $this->events()->on('activate', array($this, 'activate'));
        $this->events()->on('deactivate', array($this, 'deactivate'));
    }

    /**
     * @return RestBroker
     */
    public function ajax()
    {
        return $this->make('Nstaeger\CmsPluginFramework\Broker\RestBroker');
    }

    /**
     * @return AssetBroker
     */
    public function asset()
    {
        return $this->make('Nstaeger\CmsPluginFramework\Broker\AssetBroker');
    }

    /**
     * @return EventDispatcher
     */
    public function events()
    {
        return $this->make('Nstaeger\CmsPluginFramework\Event\EventDispatcher');
    }

    /**
     * @return MenuBroker
     */
    public function menu()
    {
        return $this->make('Nstaeger\CmsPluginFramework\Broker\MenuBroker');
    }

    /**
     * @return PermissionBroker
     */
    public function permission()
    {
        return $this->make('Nstaeger\CmsPluginFramework\Broker\PermissionBroker');
    }

    /**
     * @return TemplateRenderer
     */
    public function renderer()
    {
        return $this->make('Nstaeger\CmsPluginFramework\Templating\TemplateRenderer');
    }

    /**
     * Is being called automatically, when the plugin is being activated
     */
    protected function activate()
    {
        // noop
    }

    /**
     * is being called automatically, when the plugin is being deactivated
     */
    protected function deactivate()
    {
        // noop
    }
}
