<?php

namespace App\Services\Telegram\Interface;

use Telegram\Bot\Objects\Message;

interface EntityHelperInterface
{
    public function make(Message $data): mixed;

    public function save($entity): void;
}