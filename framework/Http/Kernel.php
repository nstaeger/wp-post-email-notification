<?php

namespace Nstaeger\Framework\Http;

use InvalidArgumentException;
use Nstaeger\Framework\Http\Exceptions\HttpInternalErrorException;
use Nstaeger\Framework\Http\Exceptions\HttpNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Kernel
{
    /**
     * @var ActionResolver
     */
    private $resolver;

    /**
     * @param ActionResolver $resolver
     */
    public function __construct(ActionResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Handle a request and transform it into a response.
     *
     * @param Request $request
     * @param mixed   $action
     * @return Response
     */
    public function handleRequest(Request $request, $action)
    {
        try {
            $callable = $this->getCallable($action);
            $response = $this->execute($callable, $request);

            if (!$response instanceof Response) {
                throw new HttpInternalErrorException('Action did not return a proper Reponse.');
            }

            return$response;
        } catch (HttpNotFoundException $e) {
            return new Response("HttpNotFoundException: " . $e->getMessage(), $e->getStatusCode());
        } catch (HttpInternalErrorException $e) {
            return new Response("HttpInternalErrorException: " . $e->getMessage(), $e->getStatusCode());
        }
    }

    /**
     * Execute the callable and handle the request.
     *
     * @param callable $callable
     * @param Request  $request
     * @return Response
     */
    private function execute($callable, $request)
    {
        return call_user_func_array($callable, [$request]);
    }

    /**
     * Transform the action into a callable.
     *
     * @param mixed $action
     * @return callable
     */
    private function getCallable($action)
    {
        try {
            return $this->resolver->resolveAction($action);
        } catch (InvalidArgumentException $e) {
            throw new HttpNotFoundException(sprintf('Unable to resolve action "%s": %s', $action, $e->getMessage()), $e);
        }
    }
}
