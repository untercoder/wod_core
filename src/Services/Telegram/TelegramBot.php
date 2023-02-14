<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Interface\CommandContainerInterface;
use App\Services\Telegram\Interface\TelegramBotInterface;
use Borsaco\TelegramBotApiBundle\Service\Bot;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

abstract class TelegramBot implements TelegramBotInterface
{
    protected Api $telegramBotApi;

    public function __construct(
        private readonly string $botName,
        private readonly Bot $apiConstruct,
        private readonly CommandContainerInterface $commandContainer,
    ) {
        $this->telegramBotApi = $this->apiConstruct->getBot($this->botName);
        $this->telegramBotApi->addCommands($this->commandContainer->getCommands());
    }

    /**
     * @return Api
     */
    public function getTelegramBotApi(): Api
    {
        return $this->telegramBotApi;
    }

    public function setUpdateHandler(bool $webhook) : Update  {
        return $this->telegramBotApi->commandsHandler($webhook);
    }

}