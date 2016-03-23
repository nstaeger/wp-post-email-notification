<?php

namespace Nstaeger\WpPostEmailNotification\Controller;

use Nstaeger\CmsPluginFramework\Controller;
use Nstaeger\WpPostEmailNotification\Model\Option;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminOptionController extends Controller
{
    public function get(Option $option)
    {
        return new JsonResponse($option->getAll());
    }

    public function update(Option $option, Request $request)
    {
        $data = json_decode($request->getContent());
        $option->setAll($data);
    }
}
