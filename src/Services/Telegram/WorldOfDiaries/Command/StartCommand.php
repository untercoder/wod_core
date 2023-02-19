<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

class StartCommand extends WodCommand
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
        $message = ($this->telegram->getWebhookUpdate())->message;

        $this->logger->debug($message);

        $this->setUser($message);

        $this->logger->debug(json_encode($this->user));

        $helloMessage = $this->textRes->trans(
            'commands.start.hello',
            ['%username%' => $this->user->getUsername()],
            'message',
            'ru'
        );

        $commandListMessage = $this->textRes->trans('commands.help.list', [], 'message', 'ru');

        $this->telegram->sendMessage([
            'chat_id' => $this->user->getChatId(),
            'text' => $helloMessage . $commandListMessage,
            'parse_mode' => 'HTML'
        ]);
    }
}