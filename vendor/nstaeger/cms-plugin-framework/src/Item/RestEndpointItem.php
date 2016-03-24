<?php

namespace Nstaeger\CmsPluginFramework\Item;

class RestEndpointItem
{
    /**
     * @var string
     */
    private $route;

    /**
     * @var string|callable
     */
    private $action;

    /**
     * @var string
     */
    private $permission;

    /**
     * @var boolean
     */
    private $enabledForUnauthorized;

    /**
     * @var string
     */
    private $method;

    /**
     * @param string $method HTTP Verb
     * @param string $route
     */
    public function __construct($method, $route)
    {
        $this->method = $method;
        $this->route = $route;
    }

    public function resolveWith($action)
    {
        $this->action = $action;

        return $this;
    }

    public function onlyWithPermission($permission)
    {
        $this->permission = $permission;
        $this->enabledForUnauthorized = false;

        return $this;
    }

    public function forUnauthorized($value)
    {
        $this->enabledForUnauthorized = $value;

        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getEnabledForUnauthorized()
    {
        return $this->enabledForUnauthorized;
    }
}
