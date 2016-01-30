<?php

namespace Nstaeger\Framework\Http;

use Nstaeger\Framework\Plugin;
use Symfony\Component\HttpFoundation\Response;

class ViewResponse extends Response
{
    public function withTemplate($template, $parameters = [])
    {
        $this->content = Plugin::instance()->templateRenderer()->render($template, $parameters);

        return $this;
    }

    public function withAsset($asset)
    {
        // TODO use asset broker!

        $path = Plugin::instance()->configuration()->getUrl() . $asset;
        wp_enqueue_script($asset, $path);

        return $this;
    }
}
