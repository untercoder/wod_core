<?php

namespace App\Services\Telegram\Interface;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

interface CallbackInterface
{
    public function action() : void;

    public function setUpdate(Update $update) : void;

    public function setApi(Api $telegram) : void;

    public function handle() : void;
}