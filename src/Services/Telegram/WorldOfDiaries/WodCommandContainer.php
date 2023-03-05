<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\Interface\CommandContainerInterface;
use App\Services\Telegram\WorldOfDiaries\Command\PublishPostWodCommand;
use App\Services\Telegram\WorldOfDiaries\Command\AboutWodCommand;
use App\Services\Telegram\WorldOfDiaries\Command\StartWodCommand;
use App\Services\Telegram\WorldOfDiaries\Command\ViewPostsWodCommand;

class WodCommandContainer implements CommandContainerInterface
{
    public function __construct(
        private readonly AboutWodCommand $helpCommand,
        private readonly StartWodCommand $startCommand,
        private readonly PublishPostWodCommand $createPostCommand,
        private readonly ViewPostsWodCommand $viewPostsCommand,
    ) {
    }

    public function getCommands() : array {
        return [
            $this->helpCommand,
            $this->startCommand,
            $this->createPostCommand,
            $this->viewPostsCommand
        ];
    }
}