<?php

namespace App\Services\Telegram;

use Borsaco\TelegramBotApiBundle\Service\Bot;
use Telegram\Bot\Api;

abstract class TelegramBot
{
    private Api $telegramBotApi;

    public function __construct(
        private readonly string $botName,
        private readonly Bot $apiConstruct,
    ) {
        $this->telegramBotApi = $this->apiConstruct->getBot($this->botName);
    }

    /**
     * @return Api
     */
    public function getTelegramBotApi(): Api
    {
        return $this->telegramBotApi;
    }

}