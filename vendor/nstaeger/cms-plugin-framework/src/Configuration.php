<?php

namespace Nstaeger\CmsPluginFramework;

class Configuration
{
    /**
     * @var array
     */
    private $config;

    /**
     * Create a new configuration
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getControllerNamespace()
    {
        return $this->config['controller_namespace'];
    }

    /**
     * @return string
     */
    public function getMainPluginFile()
    {
        return $this->config['plugin_main_file'];
    }

    /**
     * Get the main directory of the plugin.
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->config['plugin_dir'];
    }

    /**
     * Get the prefix to be used when storing options.
     *
     * @return string
     */
    public function getOptionPrefix()
    {
        return $this->config['option_prefix'];
    }

    /**
     * Get the rest prefix url/string
     */
    public function getRestPrefix()
    {
        return $this->config['rest_prefix'];
    }

    /**
     * Get the main url of the plugin e.g. for assets.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->config['plugin_url'];
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
