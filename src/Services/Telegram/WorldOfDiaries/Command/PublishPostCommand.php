<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

use App\Services\Telegram\BaseCommand;

class PublishPostCommand extends BaseCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "publish";

    /**
     * @var string Command Description
     */
    protected $description = "Создать пост";

    public function handle()
    {
        $this->initCommand();

        $action = $this->actionHelper->make($this->userCall->message);

        $action->setType($this->actionHelper::PUBlISH_ACTION);

        $action->setUserId($this->user->getId());

        $action->setState(["stage" => "validate"]);

        $this->actionHelper->save($action);

        $this->logger->info('Я publish');
    }
}