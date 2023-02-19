<?php

namespace App\Services\Telegram\WorldOfDiaries\Helper\Entity;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\Telegram\EntityHelper;
use DateTimeZone;
use Doctrine\Persistence\ManagerRegistry;
use Telegram\Bot\Objects\Message;

class UserHelper extends EntityHelper
{
    public function __construct(
        private UserRepository $userRepository,
        private ManagerRegistry $doctrine
    ) {
        parent::__construct($this->userRepository, $this->doctrine);
    }
    public function make(Message $data) : User {
        $user = new User();
        $user->setUsername($data->from->username);
        $user->setChatId($data->chat->id);
        $user->setLanguageCode($data->from->languageCode);
        $user->setlastActivity(\DateTime::createFromFormat('U', $data->date, new DateTimeZone('Europe/Moscow')));
        return $user;
    }

    public function registerUser(Message $message) : User {
        $user = $this->make($message);
        $this->save($user);
        return $user;
    }

    public function authUser(Message $message) : User|false {
        if($this->empty($message->chat->id)) {
            return false;
        }
        $user = $this->getOne(['chatId' => $message->chat->id]);
        return $user;
    }
}