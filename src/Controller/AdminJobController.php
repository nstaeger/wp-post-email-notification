<?php

namespace Nstaeger\WpPostEmailNotification\Controller;

use Nstaeger\CmsPluginFramework\Controller;
use Nstaeger\CmsPluginFramework\Http\Exceptions\HttpBadRequestException;
use Nstaeger\WpPostEmailNotification\Model\JobModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminJobController extends Controller
{
    public function delete(Request $request, JobModel $jobModel)
    {
        $job = json_decode($request->getContent());

        if (!isset($job->id) || empty($job->id)) {
            throw new HttpBadRequestException("ID was not set");
        }

        $id = intval($job->id);
        $jobModel->delete($id);

        return new JsonResponse($jobModel->getAll());
    }

    public function get(JobModel $jobModel)
    {
        return new JsonResponse($jobModel->getAll());
    }
}
