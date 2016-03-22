<?php

namespace Nstaeger\CmsPluginFramework\Http;

use InvalidArgumentException;
use Nstaeger\CmsPluginFramework\Configuration;
use Nstaeger\CmsPluginFramework\Controller;
use Nstaeger\CmsPluginFramework\Plugin;

class ActionResolver
{
    const SEPARATOR = "@";

    /**
     * @var string
     */
    private $namespace;

    /**
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->namespace = $configuration->getControllerNamespace();
    }

    /**
     * Find the controller and the corresponding function to be called
     *
     * @param mixed $action The controller to be resolved
     * @return callable
     */
    public function resolveAction($action)
    {
        if (is_string($action)) {
            if (false === strpos($action, self::SEPARATOR)) {
                throw new InvalidArgumentException(sprintf('Action "%s" is not formatted properly.', $action));
            }

            $controller = $this->namespace . "\\" . $action;

            list($class, $method) = explode(self::SEPARATOR, $controller, 2);

            if (!class_exists($class)) {
                throw new InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
            }

            $instance = $this->instantiateController($class);

            if (!method_exists($instance, $method)) {
                throw new InvalidArgumentException(sprintf('Method "%s" does not exist on class "%s".', $method, $class));
            }

            return [$instance, $method];
        }

        if (is_callable($action)) {
            return $action;
        }

        throw new InvalidArgumentException(sprintf('Action "%s" cannot be resolved.', $action));
    }

    public function execute($callable)
    {
        return Plugin::getInstance()->call($callable);
    }

    /**
     * Returns an instantiated controller.
     *
     * @param string $class A class name
     *
     * @return Controller
     */
    protected function instantiateController($class)
    {
        $instance = Plugin::getInstance()->make($class);

        if (!$instance instanceof Controller) {
            throw new InvalidArgumentException(
                sprintf('Class "%s" is not an instance of %s.', $class, Controller::class)
            );
        }

        return $instance;
    }
}
