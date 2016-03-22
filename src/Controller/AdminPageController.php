<?php

namespace Nstaeger\WpPostSubscription\Controller;

use Nstaeger\CmsPluginFramework\Controller;

class AdminPageController extends Controller
{
    public function optionsPage()
    {
        return $this->view('admin/options');
    }
}
