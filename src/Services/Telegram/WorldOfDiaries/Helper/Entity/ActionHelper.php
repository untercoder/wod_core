<?php

namespace App\Services\Telegram\WorldOfDiaries\Helper\Entity;

use App\Entity\Actions;
use App\Entity\Interface\EntityInterface;
use App\Repository\ActionsRepository;
use App\Services\Telegram\EntityHelper;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\WorldOfDiaries\Trait\DateTrait;
use Doctrine\Persistence\ManagerRegistry;
use Telegram\Bot\Objects\Message;

class ActionHelper extends EntityHelper
{
    public const  PUBlISH_ACTION = 'publish';

    public const VIEW_ACTION = 'view';

    use DateTrait;
    public function __construct(
        private ActionsRepository $repository,
        private ManagerRegistry $doctrine,
        private TelegramLogger $logger
    ) {
        parent::__construct($this->repository, $this->doctrine);
    }


    public function make(Message $data): Actions
    {
        $action = new Actions();
        $action->setChatId($data->chat->id);
        $action->setLastActivity($this->getDateTime($data->date));
        return $action;
    }

    public function getActiveAction(int $chatId): Actions|false
    {
        $action = $this->repository->findOneBy(['chatId' => $chatId]);
        if (isset($action)) {
            return $action;
        }
        return false;
    }

    public function remove(Actions $action) : void {
        $this->repository->remove($action, true);
    }

}