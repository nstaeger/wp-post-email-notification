<?php

namespace Nstaeger\WpPostSubscription\View;

use InvalidArgumentException;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

class ViewRenderer
{
    private $templateDirectory;
    private $templatingEngine;

    public function __construct($directory)
    {
        $this->templateDirectory = $directory . '/views/%name%';
    }

    public function render($template, $parameters = array())
    {
        if (strpos($template, ".php") !== strlen($template) - 4) {
            $template .= ".php";
        }

        try {
            echo $this->getTemplatingEngine()->render($template, $parameters);
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
        }
    }

    private function getTemplatingEngine()
    {
        if ($this->templatingEngine == null) {
            $this->templatingEngine = new PhpEngine(
                new TemplateNameParser(),
                new FilesystemLoader($this->templateDirectory)
            );
        }

        return $this->templatingEngine;
    }
}
