<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;




class AboutCommand extends BaseCommand
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
        $this->initCommand();

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