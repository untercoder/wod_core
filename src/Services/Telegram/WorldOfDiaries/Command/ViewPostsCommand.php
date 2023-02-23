<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

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

        $this->actionHelper->save($action);

        $this->logger->info('Я view');
    }
}