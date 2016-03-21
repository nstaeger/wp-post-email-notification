<?php

namespace Nstaeger\Framework\Menu;

use Nstaeger\Framework\Support\Str;

class MenuItem {
    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $assets;

    /**
     * @var string
     */
    private $capability;

    /**
     * @var string
     */
    private $title;

    /**
     * @param string $title
     */
    public function __construct($title)
    {
        $this->assets = array();
        $this->title = $title;
    }

    /**
     * Set the action to be executed on this menu item
     *
     * @param mixed $action
     * @return $this
     */
    public function withAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * Attach an asset to be loaded on the execution of this menu item
     *
     * @param $asset
     * @return $this
     */
    public function withAsset($asset)
    {
        $this->assets[] = $asset;
        return $this;
    }

    /**
     * Set the capability to for accessing the menu item
     *
     * @param string $capability
     * @return $this
     */
    public function withCapability($capability)
    {
        $this->capability = $capability;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getAssets()
    {
        return $this->assets;
    }

    /**
     * @return string
     */
    public function getCapability()
    {
        return $this->capability;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return Str::snake($this->title);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
