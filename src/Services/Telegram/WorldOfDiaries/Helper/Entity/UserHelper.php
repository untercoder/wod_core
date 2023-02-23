<?php

namespace App\Services\Telegram\WorldOfDiaries\Helper\Entity;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\Telegram\EntityHelper;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\WorldOfDiaries\Trait\DateTrait;
use Doctrine\Persistence\ManagerRegistry;
use Telegram\Bot\Objects\Message;

class UserHelper extends EntityHelper
{
    use DateTrait;

    public function __construct(
        private UserRepository $userRepository,
        private ManagerRegistry $doctrine,
        private TelegramLogger $logger
    ) {
        parent::__construct($this->userRepository, $this->doctrine);
    }

    public function make(Message $data): User
    {
        $user = new User();
        $user->setUsername($data->from->username);
        $user->setChatId($data->chat->id);
        $user->setLanguageCode($data->from->languageCode);
        $user->setlastActivity($this->getDateTime($data->date));
        return $user;
    }

    private function registerUser(Message $data): User
    {
        $user = $this->make($data);
        $this->save($user);
        return $user;
    }

    private function authUser(Message $data): User|false
    {
        $user = $this->userRepository->findOneBy(['chatId' => $data->chat->id]);
        if (isset($user)) {
            return $user;
        }
        return false;
    }

    public function initUser(Message $data): User
    {
        $initUser = $this->authUser($data);

        if ($initUser) {
            $initUser->setlastActivity($this->getDateTime($data->date));
        } else {
            $initUser = $this->registerUser($data);
            $this->logger->info('Новый юзер: ' . '@' . $initUser->getUsername());
        }

        return $initUser;
    }

}
