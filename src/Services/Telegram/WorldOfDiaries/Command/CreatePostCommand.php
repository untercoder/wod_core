<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

use App\Services\Telegram\BaseCommand;

class CreatePostCommand extends BaseCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "create";

    /**
     * @var string Command Description
     */
    protected $description = "Создать пост";

    public function handle()
    {
        $this->logger->info('Я create');
    }
}