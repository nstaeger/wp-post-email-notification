<?php

namespace Nstaeger\WpPostEmailNotification\Controller;

use InvalidArgumentException;
use Nstaeger\CmsPluginFramework\Controller;
use Nstaeger\CmsPluginFramework\Http\Exceptions\HttpBadRequestException;
use Nstaeger\WpPostEmailNotification\Model\SubscriberModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminSubscriberController extends Controller
{
    public function delete(Request $request, SubscriberModel $subscriberModel)
    {
        $subscriber = json_decode($request->getContent());

        if (!isset($subscriber->id) || empty($subscriber->id)) {
            throw new HttpBadRequestException("ID was not set");
        }

        $id = intval($subscriber->id);
        $subscriberModel->delete($id);

        return new JsonResponse($subscriberModel->getAll());
    }

    public function get(SubscriberModel $subscriberModel)
    {
        return new JsonResponse($subscriberModel->getAll());
    }

    public function post(Request $request, SubscriberModel $subscriberModel)
    {
        try {
            $subscriberModel->add($request);
        } catch (InvalidArgumentException $e) {
            throw new HttpBadRequestException($e->getMessage());
        }

        return new JsonResponse($subscriberModel->getAll());
    }
}
