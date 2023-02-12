<?php

namespace App\Services\Telegram\Logger;

use App\Services\Telegram\TelegramBot;
use Borsaco\TelegramBotApiBundle\Service\Bot;
use Telegram\Bot\Objects\Message;

class LoggerTelegramBot extends TelegramBot
{
    const BOT_NAME = 'log_bot';
    const PARSE_MODE = 'HTML';

    public function __construct(Bot $apiConstruct, private readonly int $LoggerChatId)
    {
        parent::__construct(self::BOT_NAME, $apiConstruct);
    }

    public function sendDebugMessage(string $messageHtml): Message
    {
        return ($this->getTelegramBotApi())->sendMessage([
            'chat_id' => $this->LoggerChatId,
            'text' => $messageHtml,
            'parse_mode' => self::PARSE_MODE
        ]);
    }


}