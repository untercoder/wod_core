<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Borsaco\TelegramBotApiBundle\Service\Bot;

class PingController extends AbstractController
{
    #[Route('/ping')]
    public function ping(): Response
    {
        return $this->json(['response' => 'ok']);
    }

    #[Route('/check_bot')]
    public function checkBot(Bot $bot) : Response
    {
        $wod_bot = $bot->getBot('wod_dev');

        $wod_bot->sendMessage([
            'chat_id' => 670407504,
            'text' => "Hello im work!",
            'parse_mod' => 'text'
        ]);

        return $this->json(['user' => $wod_bot->getMe()]);
    }

}