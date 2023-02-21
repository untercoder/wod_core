<?php

namespace App\Services\Telegram\WorldOfDiaries\Callback;

use function Symfony\Component\Translation\t;

class DontUnderstandCallback extends WodBaseCallback
{

    public function handle(): void
    {
        $this->setUser($this->update->message);

        $dontUnderstandMessage = $this->textRes->trans(
            'callback.understand.message',
            ['username' => $this->user->getUsername()],
            'message',
            'ru'
        );

        $render = $this->templates->render(
            'callback/understand.html.twig',
            ['message' => $dontUnderstandMessage]
        );

        $this->sendMessageToUser($this->user, $render, $this->telegram);
    }
}