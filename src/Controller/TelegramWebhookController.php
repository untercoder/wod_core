<?php

namespace App\Controller;

use App\Services\Telegram\Admin\AdminBot;
use App\Services\Telegram\WorldOfDiaries\WorldOfDiariesBot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TelegramWebhookController extends AbstractController
{
    #[Route('/webhooks/telegram/wod', name: 'main', methods: ['POST'])]
    public function index(WorldOfDiariesBot $bot): Response
    {
        $bot->setUpdateHandler(true);
        $bot->updateObserve();
        return new Response();
    }

    #[Route('/webhooks/telegram/admin', name: 'support', methods: ['POST'])]
    public function support(AdminBot $bot): Response
    {
        $bot->setUpdateHandler(true);
        return new Response();
    }
}