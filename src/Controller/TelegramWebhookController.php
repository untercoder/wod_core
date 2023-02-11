<?php

namespace App\Controller;

use App\Services\TelegramLogger;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TelegramWebhookController extends AbstractController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    #[Route('/webhooks/telegram')]
    public function index(Request $request): Response
    {
        $this->logger->info($request->getContent());
        return new Response();
    }
}