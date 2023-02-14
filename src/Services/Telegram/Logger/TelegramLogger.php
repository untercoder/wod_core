<?php

namespace App\Services\Telegram\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class TelegramLogger extends AbstractLogger implements LoggerInterface
{
    public function __construct(
        private readonly LoggerTelegramBot $bot
    ) {
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $this->bot->sendDebugMessage($message);
    }
}
