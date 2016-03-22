<?php

namespace Nstaeger\CmsPluginFramework\Http\Exceptions;

use Exception;
use RuntimeException;

class HttpException extends RuntimeException
{
    private $statusCode;
    private $headers;

    /**
     * HttpException constructor.
     *
     * @param string         $statusCode
     * @param null           $message
     * @param Exception|null $previous
     * @param array          $headers
     * @param int            $code
     */
    public function __construct($statusCode, $message = null, Exception $previous = null, array $headers = array(), $code = 0)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
