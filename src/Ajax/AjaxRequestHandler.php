<?php

namespace Nstaeger\WpPostSubscription\Ajax;

use Nstaeger\WpPostSubscription\Database\Database;
use Nstaeger\WpPostSubscription\Database\SubscriberModel;
use Nstaeger\WpPostSubscription\Http\BadRequestException;
use Nstaeger\WpPostSubscription\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AjaxRequestHandler
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function handle(Request $request)
    {
        // TODO check if the user is allowed to do this
        try {
            switch ($request->getAction()) {
                case 'get_subscribers':
                    return new JsonResponse((new SubscriberModel($this->database))->getAll());
                case 'add_subscriber':
                    return $this->handleAddSubscriberRequest($request);
                case 'delete_subscriber':
                    return $this->handleDeleteSubscriber($request);
                case 'subscribe':
                    return $this->handleSubscribe($request);
            }
        } catch (BadRequestException $e) {
            return new Response(null, Response::HTTP_BAD_REQUEST);
        }

        return new Response(null, Response::HTTP_NOT_FOUND);
    }

    private function handleAddSubscriberRequest(Request $request)
    {
        $subscriberModel = new SubscriberModel($this->database);

        $this->tryToAddSubscriber($request, $subscriberModel);

        return new JsonResponse($subscriberModel->getAll());
    }

    private function handleDeleteSubscriber(Request $request)
    {
        if (!isset($request->getData()->id) || empty($request->getData()->id)) {
            throw new BadRequestException();
        }

        $id = intval($request->getData()->id);

        $subscriberModel = new SubscriberModel($this->database);
        $subscriberModel->delete($id);

        return new JsonResponse($subscriberModel->getAll());
    }

    private function handleSubscribe(Request $request)
    {
        $subscriberModel = new SubscriberModel($this->database);

        $this->tryToAddSubscriber($request, $subscriberModel);

        return new JsonResponse();
    }

    private function tryToAddSubscriber(Request $request, SubscriberModel $subscriberModel)
    {
        $email = isset($request->getData()->email) ? sanitize_email($request->getData()->email) : null;
        $ip = isset($request->getData()->ip) && !empty($request->getData()->ip)
            ? $request->getData()->ip
            : $request->getClientIp();

        if (empty($email) || !is_email($email)) {
            throw new BadRequestException();
        }

        if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false
            && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false
        ) {
            throw new BadRequestException();
        }

        $subscriberModel->add($email, $ip);
    }
}
