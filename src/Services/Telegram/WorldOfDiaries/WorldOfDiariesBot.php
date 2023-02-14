<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\TelegramBot;
use Borsaco\TelegramBotApiBundle\Service\Bot;
use Telegram\Bot\Objects\Update;

class WorldOfDiariesBot extends TelegramBot
{
    private const BOT_NAME = 'wod_dev';

    public function __construct(Bot $apiConstruct, WoDCommandContainer $commandContainer)
    {
        parent::__construct(self::BOT_NAME, $apiConstruct, $commandContainer);
    }
}
