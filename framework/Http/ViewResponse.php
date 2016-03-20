<?php

namespace Nstaeger\Framework\Http;

use Nstaeger\Framework\Plugin;
use Symfony\Component\HttpFoundation\Response;

class ViewResponse extends Response
{
    public function withTemplate($template, $parameters = [])
    {
        $this->content = Plugin::getInstance()->renderer()->render($template, $parameters);

        return $this;
    }

    public function withAsset($asset)
    {
        Plugin::getInstance()->asset()->addAsset($asset);

        return $this;
    }
}
