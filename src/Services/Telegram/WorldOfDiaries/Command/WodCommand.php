<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

use App\Entity\User;
use App\Services\Telegram\BaseCommand;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\WorldOfDiaries\Helper\Entity\UserHelper;
use DateTimeZone;
use Symfony\Contracts\Translation\TranslatorInterface;
use Telegram\Bot\Objects\Message;

class WodCommand extends BaseCommand
{
    protected User $user;

    public function __construct(
        protected TranslatorInterface $textRes,
        protected TelegramLogger $logger,
        protected UserHelper $userHelper
    ) {
        parent::__construct($this->textRes, $this->logger);
    }

    public function setUser(Message $message)
    {
        $authUser = $this->userHelper->authUser($message);

        if ($authUser) {
            $this->user = $authUser;
            $this->logger->info('Пользователь ' . $this->user->getUsername() . " уже авторизован");
            $this->user->setlastActivity(
                \DateTime::createFromFormat('U', $message->date, new DateTimeZone('Europe/Moscow'))
            );
        } else {
            $this->user = $this->userHelper->registerUser($message);
            $this->logger->info('Новый юзер: ' . '@' . $this->user->getUsername());
        }
    }
}