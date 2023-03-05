<?php

namespace App\Controller;

use Borsaco\TelegramBotApiBundle\Service\Bot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PingController extends AbstractController
{
    #[Route('/', name: 'ping', condition: '%kernel.debug%' == 1)]
    public function index(Bot $bot): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $firstBot = $bot->getBot();
        return $this->json($firstBot->getMe());
    }
}