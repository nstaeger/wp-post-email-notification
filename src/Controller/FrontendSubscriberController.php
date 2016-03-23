<?php

namespace Nstaeger\WpPostEmailNotification\Controller;

use Nstaeger\CmsPluginFramework\Controller;
use Nstaeger\CmsPluginFramework\Http\Exceptions\HttpBadRequestException;
use Nstaeger\WpPostEmailNotification\Model\SubscriberModel;
use Psr\Log\InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FrontendSubscriberController extends Controller
{
    public function post(Request $request, SubscriberModel $subscriberModel)
    {
        try {
            $subscriberModel->add($request);
        } catch (InvalidArgumentException $e) {
            throw new HttpBadRequestException($e->getMessage());
        }

        return new JsonResponse();
    }
}
