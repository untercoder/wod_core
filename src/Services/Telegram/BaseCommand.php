<?php

namespace App\Services\Telegram;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Telegram\Bot\Commands\Command;

abstract class BaseCommand extends Command
{

    public function __construct(
        protected TranslatorInterface $textRes,
        protected LoggerInterface $logger
    ) {
    }

    public function handle()
    {
        // TODO: Implement handle() method.
    }
}