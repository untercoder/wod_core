<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

use App\Services\Telegram\BaseCommand;

class StartCommand extends BaseCommand
{

    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";


    public function handle()
    {
        $update = $this->telegram->getWebhookUpdate();

        $chatId = $update->message->from->id;
        $username = $update->message->from->username;

        // Create keyboard
        $keyboard = [
            "inline_keyboard" => [
                [
                    [
                        "text" => "Посмотреть анкеты",
                        "callback_data" => "view"
                    ],
                    [
                        "text" => "Создать свою",
                        "callback_data" => "create"
                    ],
                ]
            ]
        ];

        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $this->textRes->trans('start.hello', ['%username%' => $username], 'message', 'ru'),
            'reply_markup' => json_encode($keyboard)
        ]);

    }
}