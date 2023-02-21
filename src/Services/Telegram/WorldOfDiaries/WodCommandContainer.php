<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\Interface\CommandContainerInterface;
use App\Services\Telegram\WorldOfDiaries\Command\PublishPostCommand;
use App\Services\Telegram\WorldOfDiaries\Command\AboutCommand;
use App\Services\Telegram\WorldOfDiaries\Command\StartCommand;
use App\Services\Telegram\WorldOfDiaries\Command\ViewPostsCommand;

class WodCommandContainer implements CommandContainerInterface
{
    public function __construct(
        private readonly AboutCommand $helpCommand,
        private readonly StartCommand $startCommand,
        private readonly PublishPostCommand $createPostCommand,
        private readonly ViewPostsCommand $viewPostsCommand,
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