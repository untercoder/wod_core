<?php

namespace App\Services\Telegram\Admin;

use App\Services\Telegram\TelegramBot;
use Borsaco\TelegramBotApiBundle\Service\Bot;

class AdminBot extends TelegramBot
{
    private const BOT_NAME = 'admin';
    public function __construct(
        Bot $apiConstruct,
        AdminCommandContainer $commandContainer
    ) {
        parent::__construct(self::BOT_NAME, $apiConstruct, $commandContainer);
    }

}