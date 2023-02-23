<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\TelegramBot;
use App\Services\Telegram\WorldOfDiaries\Helper\Entity\ActionHelper;
use Borsaco\TelegramBotApiBundle\Service\Bot;
use Telegram\Bot\Objects\Update;

class WorldOfDiariesBot extends TelegramBot
{
    private const BOT_NAME = 'wod_dev';

    private array $commandList = ['/start', '/about', '/view', '/publish'];

    public function __construct(
        Bot $apiConstruct,
        WodCommandContainer $commandContainer,
        private CallbackObserver $callbackObserver,
        private ActionHelper $actionHelper
    ) {
        parent::__construct(self::BOT_NAME, $apiConstruct, $commandContainer);
    }

    public function callbackObserve(): void
    {
        $update = $this->telegramBotApi->getWebhookUpdate();

        if (!$this->isCommand($update)) {
            $action = $this->actionHelper->getActiveAction($update->message->chat->id);
            $callback = $this->callbackObserver->callbackFactory($action);
            $callback->setApi($this->telegramBotApi);
            $callback->setUpdate($update);
            $callback->setAction($action);
            $callback->initCallback();
        }
    }

    private function isCommand(Update $update): bool
    {
        $entities = $update->message->entities;

        if (isset($entities)) {
            foreach ($entities as $entity) {
                if ($entity->type === "bot_command" and in_array($update->message->text, $this->commandList)) {
                    return true;
                }
            }
        }

        return false;
    }
}
