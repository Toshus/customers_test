<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiExceptionEvent
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();
        $response->setStatusCode(JsonResponse::HTTP_OK);
        $response->setContent(json_encode([
            'error' => $exception->getMessage(),
            'result' => [],
        ]));
        
        $event->setResponse($response);
    }
}