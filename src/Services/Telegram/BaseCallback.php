<?php

namespace App\Services\Telegram;

use App\Entity\Actions;
use App\Services\Telegram\Interface\CallbackInterface;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\WorldOfDiaries\Trait\MessageTrait;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

abstract class BaseCallback implements CallbackInterface
{
    protected Update $update;

    protected Api $telegram;

    public function __construct(
        protected TelegramLogger $logger,
    ) {
    }


    use MessageTrait;

    public function setUpdate(Update $update): void
    {
        $this->update = $update;
    }

    public function setApi(Api $telegram): void
    {
        $this->telegram = $telegram;
    }

    public function action(): void
    {
        try {
            if (!isset($this->telegram)) {
                throw new \Exception('Undefined api telegram in ' . self::class);
            }

            if (!isset($this->update)) {
                throw new \Exception('Undefined update object in' . self::class);
            }

            $this->handle();

        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }
    }

}