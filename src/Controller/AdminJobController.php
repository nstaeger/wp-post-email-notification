<?php

namespace Nstaeger\WpPostSubscription\Controller;

use Nstaeger\Framework\Controller;
use Nstaeger\WpPostSubscription\Model\JobModel;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminJobController extends Controller
{
    public function get(JobModel $jobModel)
    {
        return new JsonResponse($jobModel->getAll());
    }
}
