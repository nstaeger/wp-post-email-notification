<?php

namespace Nstaeger\WpPostSubscription\Controller;

use Nstaeger\Framework\Controller;

class AdminPageController extends Controller
{
    public function optionsPage()
    {
        return $this->view('admin/options')->withAsset('js/bundle/admin-options.js');
    }
}
