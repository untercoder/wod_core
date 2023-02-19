<?php

namespace App\Services\Telegram;

use App\Services\Telegram\Logger\TelegramLogger;
use Symfony\Contracts\Translation\TranslatorInterface;
use Telegram\Bot\Commands\Command;

abstract class BaseCommand extends Command
{

    public function __construct(
        protected TranslatorInterface $textRes,
        protected TelegramLogger $logger
    ) {
    }

    public function handle()
    {
        // TODO: Implement handle() method.
    }
}