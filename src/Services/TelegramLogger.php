<?php

namespace App\Services;

use Borsaco\TelegramBotApiBundle\Service\Bot;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Telegram\Bot\Api;
use Twig\Environment;

class TelegramLogger extends AbstractLogger implements LoggerInterface
{
    public function __construct(
        private string $logBotName,
        private Bot $apiConstruct,
        private int $loggerChatId,
        private Environment $twig,
    ) {}

    private function getTelegramBotApi(): Api
    {
        return $this->apiConstruct->getBot($this->logBotName);
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $telegramBotApi = $this->getTelegramBotApi();

        $telegramBotApi->sendMessage([
            'chat_id' => $this->loggerChatId,
            'text' => $this->buildLogMessage([
                'level' => $level,
                'message' => $message,
                'context' => $context
            ]),
            'parse_mode' => 'HTML'
        ]);
    }

    private function buildLogMessage(array $params): string
    {
        return $this->twig->render('tg_log_message.html.twig', $params);
    }

}
