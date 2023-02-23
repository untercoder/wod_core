<?php

namespace App\Services\Telegram\WorldOfDiaries\Callback;

class ViewCallback extends WodBaseCallback
{

    public function handle(): void
    {
        $this->setUser($this->update->message);

        $this->sendMessageToUser($this->user, 'Йоу я callback просмотра', $this->telegram);
    }
}