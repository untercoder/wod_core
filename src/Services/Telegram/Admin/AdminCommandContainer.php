<?php

namespace App\Services\Telegram\Admin;

use App\Services\Telegram\Admin\Command\StartWodCommand;
use App\Services\Telegram\Interface\CommandContainerInterface;

class AdminCommandContainer implements CommandContainerInterface
{
    public function __construct(
        private readonly StartWodCommand $startCommand
    )
    {
    }

    public function getCommands(): array
    {
        return [$this->startCommand,];
    }
}