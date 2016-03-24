<?php

namespace Nstaeger\CmsPluginFramework\Http;

use Nstaeger\CmsPluginFramework\Plugin;
use Symfony\Component\HttpFoundation\Response;

class ViewResponse extends Response
{
    // TODO inject dependencies?
    public function withTemplate($template, $parameters = [])
    {
        $this->content = Plugin::getInstance()->renderer()->render($template, $parameters);

        return $this;
    }
}
