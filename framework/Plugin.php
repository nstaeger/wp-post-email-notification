<?php

namespace Nstaeger\Framework;

use Illuminate\Container\Container;
use Nstaeger\Framework\Broker\AssetBroker;
use Nstaeger\Framework\Broker\EventBroker;
use Nstaeger\Framework\Broker\MenuBroker;
use Nstaeger\Framework\Broker\RestBroker;
use Nstaeger\Framework\Creator\Creator;
use Nstaeger\Framework\Event\EventDispatcher;
use Nstaeger\Framework\Templating\TemplateRenderer;
use Symfony\Component\HttpFoundation\Request;

/**
 * TODO cleanup dependencies
 */
class Plugin extends Container
{
    public function __construct(Configuration $configuration, Creator $creator)
    {
        self::setInstance($this);

        $this->instance(Configuration::class, $configuration);
        $this->singleton(EventDispatcher::class, EventDispatcher::class);
        $creator->build($this);

        // register regular events from system
        $this->make(EventBroker::class)->fireAll($this->events());

        // regular request
        $this->singleton(
            Request::class,
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
        return $this->make(RestBroker::class);
    }

    /**
     * @return AssetBroker
     */
    public function asset()
    {
        return $this->make(AssetBroker::class);
    }

    /**
     * @return EventDispatcher
     */
    public function events()
    {
        return $this->make(EventDispatcher::class);
    }

    /**
     * @return MenuBroker
     */
    public function menu()
    {
        return $this->make(MenuBroker::class);
    }

    /**
     * @return TemplateRenderer
     */
    public function renderer()
    {
        return $this->make(TemplateRenderer::class);
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
