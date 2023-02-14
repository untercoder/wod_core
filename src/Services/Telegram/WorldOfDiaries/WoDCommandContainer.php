<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\Interface\CommandContainerInterface;
use App\Services\Telegram\WorldOfDiaries\Command\HelpCommand;
use App\Services\Telegram\WorldOfDiaries\Command\StartCommand;

class WoDCommandContainer implements CommandContainerInterface
{
    public function __construct(
        private HelpCommand $helpCommand,
        private StartCommand $startCommand
    ) {
    }

    public function getCommands() : array {
        return [
            $this->helpCommand,
            $this->startCommand,
        ];
    }
}