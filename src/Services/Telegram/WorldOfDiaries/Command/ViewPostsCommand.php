<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

use App\Services\Telegram\BaseCommand;

class ViewPostsCommand extends BaseCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "view";

    /**
     * @var string Command Description
     */
    protected $description = "Смотреть посты";

    public function handle()
    {
        $this->logger->info('Я view');
    }
}