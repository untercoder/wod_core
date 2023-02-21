<?php

namespace App\Services\Telegram\WorldOfDiaries\Trait;

use App\Entity\User;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message;

trait MessageTrait
{
    protected function sendMessageToUser(User $user, string $renderTemplate, Api $telegram): Message
    {
        return $telegram->sendMessage(
            [
                'chat_id' => $user->getChatId(),
                'text' => $renderTemplate,
                'parse_mode' => 'HTML'
            ]
        );
    }
}