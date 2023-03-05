<?php

namespace App\Helper\Entity;

use App\Entity\Action;
use App\Repository\ActionRepository;
use App\Services\Telegram\EntityHelper;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Trait\DateTrait;
use Doctrine\Persistence\ManagerRegistry;
use Telegram\Bot\Objects\Message;

class ActionHelper extends EntityHelper
{
    public const  PUBlISH_ACTION = 'publish';

    public const VIEW_ACTION = 'view';

    use DateTrait;
    public function __construct(
        private ActionRepository $repository,
        private ManagerRegistry $doctrine,
        private TelegramLogger $logger
    ) {
        parent::__construct($this->repository, $this->doctrine);
    }


    public function make(Message $data): Action
    {
        $action = new Action();
        $action->setChatId($data->chat->id);
        $action->setLastActivity($this->getDateTime($data->date));
        return $action;
    }

    public function getActiveAction(int $chatId): Action|false
    {
        $action = $this->repository->findOneBy(['chatId' => $chatId]);
        if (isset($action)) {
            return $action;
        }
        return false;
    }

    public function remove(Action $action) : void {
        $this->repository->remove($action, true);
    }

}