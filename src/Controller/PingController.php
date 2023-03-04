<?php

namespace App\Controller;

use Borsaco\TelegramBotApiBundle\Service\Bot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PingController extends AbstractController
{
    #[Route('/')]
    public function index(Bot $bot): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $firstBot = $bot->getBot('wod');
        return $this->json($firstBot->getMe());
    }
}