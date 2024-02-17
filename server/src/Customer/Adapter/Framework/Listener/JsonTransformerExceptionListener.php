<?php

namespace Customer\Adapter\Framework\Listener;

use Customer\Domain\Exception\CustomerAlreadyExistsException;
use Customer\Domain\Exception\InvalidArgumentException;
use Customer\Domain\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class JsonTransformerExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        $data = [
            'class' => get_class($e),
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $e->getMessage(),
        ];

        if ($e instanceof ResourceNotFoundException) {
            $data['code'] = Response::HTTP_NOT_FOUND;
        }

        if ($e instanceof InvalidArgumentException) {
            $data['code'] = Response::HTTP_BAD_REQUEST;
        }

        if ($e instanceof AccessDeniedException) {
            $data['code'] = Response::HTTP_FORBIDDEN;
        }

        if ($e instanceof CustomerAlreadyExistsException) {
            $data['code'] = Response::HTTP_CONFLICT;
        }

        $response = new JsonResponse($data, $data['code']);

        $event->setResponse($response);
    }
}
