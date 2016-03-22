<?php

namespace Nstaeger\CmsPluginFramework;

use Nstaeger\CmsPluginFramework\Http\ViewResponse;

class Controller
{
    /**
     * @param string $template
     * @param array  $parameters
     * @return ViewResponse
     */
    protected function view($template, $parameters = [])
    {
        return (new ViewResponse())->withTemplate($template, $parameters);
    }
}