<?php

namespace Nstaeger\WpPostSubscription\Controller;

use Nstaeger\Framework\Controller;
use Nstaeger\Framework\Http\Exceptions\HttpBadRequestException;
use Nstaeger\WpPostSubscription\Model\SubscriberModel;
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
