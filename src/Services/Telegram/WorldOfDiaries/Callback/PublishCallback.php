<?php

namespace App\Services\Telegram\WorldOfDiaries\Callback;

class PublishCallback extends WodBaseCallback
{

    public function handle(): void
    {
        $this->setUser($this->update->message);

        $this->sendMessageToUser($this->user, "Йоу я callback публикации", $this->telegram);
    }
}