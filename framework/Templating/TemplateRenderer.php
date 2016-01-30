<?php

namespace Nstaeger\Framework\Templating;

use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\TemplateReferenceInterface;

class TemplateRenderer
{
    /**
     * @var string
     */
    private $templateDirectory;

    /**
     * @var PhpEngine
     */
    private $templatingEngine;

    /**
     * TemplateRenderer constructor.
     *
     * @param string $directory Main directory for views with no trailing slash.
     */
    public function __construct($directory)
    {
        $this->templateDirectory = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '%name%';
    }

    /**
     * Print a template.
     *
     * @param string|TemplateReferenceInterface $name       A template name or a TemplateReferenceInterface instance
     * @param array                             $parameters An array of parameters to pass to the template
     */
    public function renderAndPrint($template, $parameters = array())
    {
        try {
            echo $this->render($template, $parameters);
        } catch (RuntimeException $e) {
            echo $e->getMessage();
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Renders a template.
     *
     * @param string|TemplateReferenceInterface $name       A template name or a TemplateReferenceInterface instance
     * @param array                             $parameters An array of parameters to pass to the template
     *
     * @return string The evaluated template as a string
     *
     * @throws \RuntimeException if the template cannot be rendered
     * @throws \InvalidArgumentException if the template does not exist
     */
    public function render($template, $parameters = array())
    {
        $template = $this->parseTemplate($template);

        return $this->getTemplatingEngine()->render($template, $parameters);
    }

    /**
     * Get the templating engine. Initialize it, if not done yet.
     *
     * @return PhpEngine
     */
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

    /**
     * @param string $template Add the PHP-extension to the template file name.
     * @return string Filename
     */
    private function parseTemplate($template)
    {
        if (is_string($template)) {
            $template = str_replace("/", DIRECTORY_SEPARATOR, $template);

            if (strpos($template, ".php") !== strlen($template) - 4) {
                $template .= ".php";
            }
        }

        return $template;
    }
}
