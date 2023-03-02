<?php

namespace App\Services\Telegram\Interface;

use Telegram\Bot\Objects\Message;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\CallbackQuery;

interface CallbackInterface
{
    public function initCallback() : void;

    public function setMessage(Message $message) : void;

    public function setCallback(CallbackQuery $callback);

    public function setApi(Api $telegram) : void;

    public function handle() : void;
}