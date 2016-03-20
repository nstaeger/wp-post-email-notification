<?php

namespace Nstaeger\WpPostSubscription\Controller;

use Nstaeger\Framework\Controller;
use Nstaeger\Framework\Http\Exceptions\HttpBadRequestException;
use Nstaeger\WpPostSubscription\Database\SubscriberModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminAjaxController extends Controller
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
        $this->tryToAddSubscriber($request, $subscriberModel);

        return new JsonResponse($subscriberModel->getAll());
    }

    private function tryToAddSubscriber(Request $request, SubscriberModel $subscriberModel)
    {
        $subscriber = json_decode($request->getContent());

        $email = isset($subscriber->email) ? sanitize_email($subscriber->email) : null;
        $ip = isset($subscriber->ip) && !empty($subscriber->ip)
            ? $subscriber->ip
            : $request->getClientIp();

        if (empty($email) || !is_email($email)) {
            throw new HttpBadRequestException("Email not valid.");
        }

        if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false
            && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false
        ) {
            throw new HttpBadRequestException("IP not valid.");
        }

        $subscriberModel->add($email, $ip);
    }
}
