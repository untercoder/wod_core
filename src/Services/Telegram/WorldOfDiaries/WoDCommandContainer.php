<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\Interface\CommandContainerInterface;
use App\Services\Telegram\WorldOfDiaries\Command\CreatePostCommand;
use App\Services\Telegram\WorldOfDiaries\Command\HelpCommand;
use App\Services\Telegram\WorldOfDiaries\Command\StartCommand;
use App\Services\Telegram\WorldOfDiaries\Command\ViewPostsCommand;

class WoDCommandContainer implements CommandContainerInterface
{
    public function __construct(
        private HelpCommand $helpCommand,
        private StartCommand $startCommand,
        private CreatePostCommand $createPostCommand,
        private ViewPostsCommand $viewPostsCommand,
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