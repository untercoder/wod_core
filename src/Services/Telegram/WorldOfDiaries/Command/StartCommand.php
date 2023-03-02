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
        $this->initCommand();
        //dev
        $this->logger->debug(json_encode($this->user));

        $helloMessage = $this->textRes->trans(
            'commands.start.hello',
            ['%username%' => $this->user->getUsername()],
            'message',
            'ru'
        );

        $commandListMessage = $this->textRes->trans(
            'commands.help.list',
            [],
            'message',
            'ru'
        );

        $commandListTitleMessage = $this->textRes->trans(
            'commands.help.title',
            [],
            'message',
            'ru'
        );

        $responseMessage = $this->template->render(
            'command/start.html.twig',
            [
                'hello' => $helloMessage,
                'list_title' => $commandListTitleMessage,
                'list' => $commandListMessage
            ]
        );

        $this->sendMessageToUserTemplate($this->user, $responseMessage, $this->telegram);
    }
}