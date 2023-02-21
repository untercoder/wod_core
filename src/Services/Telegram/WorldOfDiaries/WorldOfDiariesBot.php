<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\TelegramBot;
use Borsaco\TelegramBotApiBundle\Service\Bot;
use Telegram\Bot\Objects\Update;

class WorldOfDiariesBot extends TelegramBot
{
    private const BOT_NAME = 'wod_dev';

    public function __construct(
        Bot $apiConstruct,
        WodCommandContainer $commandContainer,
        private CallbackObserver $callbackObserver
    ) {
        parent::__construct(self::BOT_NAME, $apiConstruct, $commandContainer);
    }

    public function callbackObserve(): void
    {
        $update = $this->telegramBotApi->getWebhookUpdate();

        if (!$this->isCommand($update)) {
            $callback = $this->callbackObserver->callbackFactory();
            $callback->setApi($this->telegramBotApi);
            $callback->setUpdate($update);
            $callback->action();
        }
    }

    private function isCommand(Update $update): bool
    {
        $entities = $update->message->entities;

        if (isset($entities)) {
            foreach ($entities as $entity) {
                if ($entity->type === "bot_command") {
                    return true;
                }
            }
        }

        return false;
    }
}
