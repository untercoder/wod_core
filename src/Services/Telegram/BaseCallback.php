<?php

namespace App\Services\Telegram;

use App\Entity\Action;
use App\Services\Telegram\Interface\CallbackInterface;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Trait\MessageTrait;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\CallbackQuery;
use Telegram\Bot\Objects\Message;

abstract class BaseCallback implements CallbackInterface
{
    protected ?Api $telegram = null;

    protected ?Message $message = null;

    protected ?CallbackQuery $callback = null;

    protected Action|false $action = false;

    public function __construct(
        protected TelegramLogger $logger,
    ) {
    }

    use MessageTrait;

    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

    public function setCallback(CallbackQuery $callback)
    {
        $this->callback = $callback;
    }

    public function setApi(Api $telegram): void
    {
        $this->telegram = $telegram;
    }

    /**
     * @param Action $action
     */
    public function setAction(Action|false $action): void
    {
        $this->action = $action;
    }

    public function initCallback(): void
    {
        try {
            if (!isset($this->telegram)) {
                throw new \Exception('Undefined api telegram in ' . self::class);
            }

            if (!isset($this->message) && !isset($this->callback)) {
                throw new \Exception('Undefined message and callback object in' . self::class);
            }

            $this->handle();

        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }
    }



}