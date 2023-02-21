<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;


use App\Services\Telegram\BaseCommand;

class AboutCommand extends WodBaseCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "about";

    /**
     * @var string Command Description
     */
    protected $description = "My new help command!";

    public function handle()
    {
        $initMessage = ($this->telegram->getWebhookUpdate())->message;

        $this->setUser($initMessage);

        $infoMessage = $this->textRes->trans(
            'commands.about.info',
            [],
            'message',
            'ru'
        );

        $this->template->render(
            'command/about.html.twig',
            [
                'info' => $infoMessage
            ]
        );

       $this->sendMessageToUser($this->user, $infoMessage, $this->telegram);
    }
}