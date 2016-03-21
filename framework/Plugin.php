<?php

namespace Nstaeger\Framework;

use Illuminate\Container\Container;
use Nstaeger\Framework\Broker\AssetBroker;
use Nstaeger\Framework\Broker\MenuBroker;
use Nstaeger\Framework\Broker\RestBroker;
use Nstaeger\Framework\Creator\Creator;
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
        $creator->build($this);

        $this->bind([Request::class], function($app) {
            return Request::createFromGlobals();
        });
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
}
