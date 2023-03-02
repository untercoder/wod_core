<?php

namespace App\Services\Telegram\WorldOfDiaries\Trait;

use App\Entity\Post;
use App\Entity\User;
use App\Services\Telegram\WorldOfDiaries\Helper\Keyboard\Keyboard;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message;

trait MessageTrait
{
    protected function sendMessageToUserTemplate(User $user, string $renderTemplate, Api $telegram): Message
    {
        return $telegram->sendMessage(
            [
                'chat_id' => $user->getChatId(),
                'text' => $renderTemplate,
                'parse_mode' => 'HTML'
            ]
        );
    }

    protected function sendPostToUser(User $user, Post $post, Api $telegram) : Message
    {
        return $telegram->copyMessage(
            [
                'chat_id' => $user->getChatId(),
                'from_chat_id' => $post->getChatId(),
                'message_id' => $post->getPostId()
            ]
        );
    }

    protected function sendPostToUserWithKeyboard(User $user, Post $post, Api $telegram, Keyboard $keyboard) : Message
    {
        return $telegram->copyMessage(
            [
                'chat_id' => $user->getChatId(),
                'from_chat_id' => $post->getChatId(),
                'message_id' => $post->getPostId(),
                'reply_markup' => json_encode($keyboard->getKeyboard())
            ]
        );
    }
}