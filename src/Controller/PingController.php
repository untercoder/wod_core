<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
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
    public function checkBot(Bot $bot, LoggerInterface $logger): Response
    {
        $wod_bot = $bot->getBot('wod_dev');

        $user = $wod_bot->getMe();
        $message_obj = $wod_bot->sendMessage([
            'chat_id' => 670407504,
            'text' => "Hello im work!",
            'parse_mod' => 'text'
        ]);

        $logger->info($message_obj);
        $logger->info($user);

        return $this->json(['user' => $user]);
    }

}