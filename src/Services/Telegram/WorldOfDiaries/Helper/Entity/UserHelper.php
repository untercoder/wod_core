<?php

namespace App\Services\Telegram\WorldOfDiaries\Helper\Entity;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\Telegram\EntityHelper;
use App\Services\Telegram\Logger\TelegramLogger;
use DateTimeZone;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Request;
use Telegram\Bot\Objects\Message;

class UserHelper extends EntityHelper
{
    public function __construct(
        private UserRepository $userRepository,
        private ManagerRegistry $doctrine,
        private TelegramLogger $logger
    ) {
        parent::__construct($this->userRepository, $this->doctrine);
    }
    public function make(Message $data) : User {
        $user = new User();
        $user->setUsername($data->from->username);
        $user->setChatId($data->chat->id);
        $user->setLanguageCode($data->from->languageCode);
        $user->setlastActivity($this->getDateTime($data->date));
        return $user;
    }

    private function registerUser(Message $data) : User {
        $user = $this->make($data);
        $this->save($user);
        return $user;
    }

    private function authUser(Message $data) : User|false {
        if($this->empty($data->chat->id)) {
            return false;
        }
        $user = $this->getOne(['chatId' => $data->chat->id]);
        return $user;
    }

    public function initUser(Message $data) : User
    {
        $initUser = $this->authUser($data);

        if ($initUser) {
            $this->logger->info('Пользователь ' . $initUser->getUsername() . " уже авторизован");
            $initUser->setlastActivity($this->getDateTime($data->date));
        } else {
            $initUser = $this->registerUser($data);
            $this->logger->info('Новый юзер: ' . '@' . $initUser->getUsername());
        }

        return $initUser;
    }

    private function getDateTime(int $unixtime): \DateTime{
        return \DateTime::createFromFormat('U', $unixtime, new DateTimeZone('Europe/Moscow'));
    }
}