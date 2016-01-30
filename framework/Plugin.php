<?php

namespace Nstaeger\Framework;

use Nstaeger\framework\Broker\DatabaseBroker;
use Nstaeger\Framework\Broker\MenuBroker;
use Nstaeger\Framework\Creator\Creator;
use Nstaeger\Framework\Http\ActionResolver;
use Nstaeger\Framework\Http\Kernel;
use Nstaeger\Framework\Templating\TemplateRenderer;

class Plugin
{
    /**
     * @var Plugin
     */
    protected static $instance;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var TemplateRenderer
     */
    private $templateRenderer;

    /**
     * @var DatabaseBroker
     */
    private $database;

    /**
     * @var MenuBroker
     */
    private $menu;

    public static function instance()
    {
        if (self::$instance == null) {
            throw new \UnexpectedValueException("Trying to access Plugin::self(), but Plugin was not initialized.");
        }

        return self::$instance;
    }

    public function __construct(Configuration $configuration, Creator $creator)
    {
        self::$instance = $this;

        $this->configuration = $configuration;

        $this->kernel = new Kernel(new ActionResolver($configuration->getControllerNamespace()));
        $this->templateRenderer = new TemplateRenderer($configuration->getViewDirectory());

        $this->create($creator);
    }

    /**
     * Initializes the private attributes.
     *
     * @param Creator $creator
     */
    private function create(Creator $creator)
    {
        $this->database = $creator->getDatabaseBroker();
        $this->menu = $creator->getMenuBroker($this->kernel);
    }

    /**
     * Get the Plugin Configuration.
     *
     * @return Configuration
     */
    public function configuration()
    {
        return $this->configuration;
    }

    /**
     * Get the DatabaseBroker.
     *
     * @return DatabaseBroker
     */
    public function database()
    {
        return $this->database;
    }

    /**
     * Get the MenuBroker.
     *
     * @return MenuBroker
     */
    public function menu()
    {
        return $this->menu;
    }

    /**
     * Get the TemplateRenderer.
     *
     * @return TemplateRenderer
     */
    public function templateRenderer()
    {
        return $this->templateRenderer;
    }
}
