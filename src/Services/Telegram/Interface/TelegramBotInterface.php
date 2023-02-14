<?php

namespace App\Services\Telegram\Interface;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

interface TelegramBotInterface
{
    public function getTelegramBotApi(): Api;
    public function setUpdateHandler(bool $webhook) : Update;
}