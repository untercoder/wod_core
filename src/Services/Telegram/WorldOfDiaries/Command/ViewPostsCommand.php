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
        $this->initCommand();

        $action = $this->actionHelper->make($this->userCall->message);

        $action->setType($this->actionHelper::VIEW_ACTION);

        $action->setUserId($this->user->getId());

        $this->actionHelper->save($action);

        $this->logger->info('Я view');
    }
}