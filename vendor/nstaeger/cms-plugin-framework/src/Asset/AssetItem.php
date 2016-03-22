<?php

namespace Nstaeger\CmsPluginFramework\Asset;

class AssetItem
{
    /**
     * The hook on which the asset should be available (admin only)
     *
     * @var string
     */
    private $hook;

    /**
     * @var string
     */
    private $url;

    /**
     * @param string $url URL to the asset, relative from plugin url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $hook load asset only on the specified hook (admin only)
     * @return $this
     */
    public function onlyOn($hook)
    {
        $this->hook = $hook;

        return $this;
    }

    /**
     * @return string may be null
     */
    public function getHook()
    {
        return $this->hook;
    }

    /**
     * @return string
     */
    public function getName()
    {
        // TODO what about a real name?
        return $this->url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
