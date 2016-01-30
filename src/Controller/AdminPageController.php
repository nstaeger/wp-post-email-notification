<?php

namespace Nstaeger\WpPostSubscription\Controller;

use Nstaeger\Framework\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminPageController extends Controller
{
    public function optionsPage(Request $request)
    {
        return $this->view('admin/options')->withAsset('js/bundle/admin-options.js');
    }
}
