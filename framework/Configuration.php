<?php

namespace Nstaeger\Framework;

class Configuration
{
    /**
     * @var string
     */
    private $directory;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $controllerNamespace;

    /**
     * Create a new configuration
     *
     * @param string $directory           The main directory of the plugin
     * @param string $url                 The main url of the plugin e.g. for assets
     * @param string $controllerNamespace The namespace in which to look for controllers
     */
    public function __construct($directory, $url, $controllerNamespace)
    {
        $this->directory = $directory;
        $this->url = $url;
        $this->controllerNamespace = $controllerNamespace;
    }

    /**
     * @return string
     */
    public function getControllerNamespace()
    {
        return $this->controllerNamespace;
    }

    /**
     * Get the main directory of the plugin.
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Get the main url of the plugin e.g. for assets.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the directory for views
     *
     * @return string
     */
    public function getViewDirectory()
    {
        return $this->getDirectory() . DIRECTORY_SEPARATOR . 'views';
    }
}
