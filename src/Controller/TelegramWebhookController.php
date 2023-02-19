<?php

namespace App\Controller;

use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\WorldOfDiaries\WorldOfDiariesBot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TelegramWebhookController extends AbstractController
{
    #[Route('/webhooks/telegram')]
    public function index(WorldOfDiariesBot $bot): Response
    {
        $bot->setUpdateHandler(true);
        return new Response();
    }
}