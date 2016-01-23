<?php

namespace Nstaeger\WpPostSubscription\Http;

use Symfony\Component\HttpFoundation\Request as BaseRequest;

class Request extends BaseRequest
{
    private $jsonData;

    public function isJson()
    {
        return $this->getContentType() == "json";
    }

    public function getJson()
    {
        if (is_null($this->jsonData)) {
            if ($this->isJson()) {
                $this->jsonData = json_decode($this->getContent());
            } else {
                $this->jsonData = new \stdClass();
            }
        }

        return $this->jsonData;
    }

    public function getAction()
    {
        return isset($this->getJson()->action) ? $this->getJson()->action : "";
    }

    public function getData()
    {
        return isset($this->getJson()->data) ? $this->getJson()->data : new \stdClass();
    }
}
