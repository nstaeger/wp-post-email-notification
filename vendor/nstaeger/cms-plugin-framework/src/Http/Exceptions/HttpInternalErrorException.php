<?php

namespace Nstaeger\CmsPluginFramework\Http\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class HttpInternalErrorException extends HttpException
{
    /**
     * @param string     $message  The internal exception message
     * @param \Exception $previous The previous exception
     * @param int        $code     The internal exception code
     */
    public function __construct($message = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct(Response::HTTP_INTERNAL_SERVER_ERROR, $message, $previous, array(), $code);
    }
}
