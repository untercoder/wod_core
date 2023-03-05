<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Helper\Entity\ActionHelper;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\TelegramBot;
use Borsaco\TelegramBotApiBundle\Service\Bot;
use Doctrine\DBAL\Exception;
use Telegram\Bot\Objects\CallbackQuery;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

class WorldOfDiariesBot extends TelegramBot
{
    private const BOT_NAME = 'wod';

    private array $commandList = ['/start', '/about', '/view', '/publish'];

    private const UPDATE_TYPE_MESSAGE = 'message';

    private const UPDATE_TYPE_CALLBACK = 'callback';

    private const UPDATE_TYPE_UNDEFINED = 'undefined';

    public function __construct(
        Bot $apiConstruct,
        WodCommandContainer $commandContainer,
        private CallbackObserver $callbackObserver,
        private ActionHelper $actionHelper,
        private TelegramLogger $logger
    ) {
        parent::__construct(self::BOT_NAME, $apiConstruct, $commandContainer);
    }

    public function updateObserve(): void
    {
        $update = $this->telegramBotApi->getWebhookUpdate();
        try {
            match ($this->getUpdateType($update)) {
                self::UPDATE_TYPE_MESSAGE => $this->workWithMessageUpdate($update->message),
                self::UPDATE_TYPE_CALLBACK => $this->workWithCallbackUpdate($update->callbackQuery),
                self::UPDATE_TYPE_UNDEFINED => $this->undefinedTypeException()
            };
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }
    }

    private function isCommand(Message $message): bool
    {
        $entities = $message->entities;

        if ($entities !== null) {
            foreach ($entities as $entity) {
                if ($entity->type === "bot_command" and in_array($message->text, $this->commandList)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function workWithMessageUpdate(Message $message): void
    {
        if (!$this->isCommand($message)) {
            $action = $this->actionHelper->getActiveAction($message->chat->id);

            $callbackAction = $this->callbackObserver->callbackFactory($action);
            $callbackAction->setApi($this->telegramBotApi);
            $callbackAction->setMessage($message);
            $callbackAction->setAction($action);
            $callbackAction->initCallback();
        }
    }

    private function workWithCallbackUpdate(CallbackQuery $callback): void
    {
        $action = $this->actionHelper->getActiveAction($callback->message->chat->id);

        $callbackAction = $this->callbackObserver->callbackFactory($action);
        $callbackAction->setApi($this->telegramBotApi);
        $callbackAction->setCallback($callback);
        $callbackAction->setAction($action);
        $callbackAction->initCallback();
    }

    private function getUpdateType(Update $update): string
    {
        if ($update->callbackQuery !== null) {
            return self::UPDATE_TYPE_CALLBACK;
        }

        if ($update->message !== null) {
            return self::UPDATE_TYPE_MESSAGE;
        }

        return self::UPDATE_TYPE_UNDEFINED;
    }

    private function undefinedTypeException(): Exception
    {
        return throw new \Exception('Undefined update type ' . self::class);
    }
}
