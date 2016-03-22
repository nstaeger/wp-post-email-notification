<?php

namespace Nstaeger\CmsPluginFramework\Http;

use Nstaeger\CmsPluginFramework\Plugin;
use Symfony\Component\HttpFoundation\Response;

class ViewResponse extends Response
{
    // TODO inject dependencies

    public function withTemplate($template, $parameters = [])
    {
        $this->content = Plugin::getInstance()->renderer()->render($template, $parameters);

        return $this;
    }

    /**
     * TODO may be removed
     */
    public function withAdminAsset($asset)
    {
        Plugin::getInstance()->asset()->addAdminAsset($asset);

        return $this;
    }

    /**
     * TODO may be removed
     */
    public function withAsset($asset)
    {
        Plugin::getInstance()->asset()->addAsset($asset);

        return $this;
    }
}
