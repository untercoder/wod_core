<?php

namespace App\Services\Telegram\Logger;

use App\Services\Telegram\Interface\CommandContainerInterface;

class LoggerCommandContainer implements CommandContainerInterface
{

    public function getCommands(): array
    {
        return [];
    }
}