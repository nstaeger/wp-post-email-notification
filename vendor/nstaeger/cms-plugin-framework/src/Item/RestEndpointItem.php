<?php

namespace Nstaeger\CmsPluginFramework\Item;

class RestEndpointItem
{
    /**
     * @var boolean
     */
    private $accessibleForAuthorized;

    /**
     * @var boolean
     */
    private $accessibleForUnauthorized;

    /**
     * @var string|callable
     */
    private $action;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $requiredPermission;

    /**
     * @var string
     */
    private $route;

    /**
     * @param string $method HTTP Verb
     * @param string $route
     */
    public function __construct($method, $route)
    {
        $this->accessibleForAuthorized = true;
        $this->accessibleForUnauthorized = false;
        $this->method = $method;
        $this->route = $route;
    }

    public function accessibleForAuthorized()
    {
        return $this->accessibleForAuthorized;
    }

    public function accessibleForUnauthorized()
    {
        return $this->accessibleForUnauthorized;
    }

    public function enableForUnauthorized($value = true)
    {
        $this->accessibleForUnauthorized = $value;

        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getRequiredPermission()
    {
        return $this->requiredPermission;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function onlyWithPermission($permission)
    {
        $this->requiredPermission = $permission;
        $this->accessibleForUnauthorized = false;

        return $this;
    }

    public function resolveWith($action)
    {
        $this->action = $action;

        return $this;
    }
}

