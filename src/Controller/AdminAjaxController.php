<?php

namespace Nstaeger\WpPostSubscription\Controller;

use Nstaeger\Framework\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminAjaxController extends Controller
{
    public function get()
    {
        return new JsonResponse([]);
    }
}
