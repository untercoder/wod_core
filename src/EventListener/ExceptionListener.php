<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;
use Twig\Environment;

class ExceptionListener
{

    public function __construct(private Environment $twig, private LoggerInterface $logger)
    {
    }

    public function __invoke(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $this->logger->debug($this->htmlErrorMessage($exception));
    }

    private function htmlErrorMessage(Throwable $exception): string
    {
        return $this->twig->render('logger/error_message.html.twig', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);
    }

}