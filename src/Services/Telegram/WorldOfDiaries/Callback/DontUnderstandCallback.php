<?php

namespace App\Services\Telegram\WorldOfDiaries\Callback;

class DontUnderstandCallback extends WodBaseCallback
{

    private string $render;
    public function handle(): void
    {
        if($this->message !== null) {

            $this->setUser($this->message);

            $dontUnderstandMessage = $this->textRes->trans(
                'callback.understand.message',
                ['username' => $this->user->getUsername()],
                'message',
                'ru'
            );

            $this->render = $this->templates->render(
                'callback/understand.html.twig',
                ['message' => $dontUnderstandMessage]
            );
        }

        if($this->callback !== null) {

            $this->setUser($this->callback->message);

            $this->render = "Круто ты нажал на кнопку! Но она уже не активна(";
        }

        $this->sendMessageToUserTemplate($this->user, $this->render, $this->telegram);
    }
}