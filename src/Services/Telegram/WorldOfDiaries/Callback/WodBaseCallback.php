<?php

namespace App\Services\Telegram\WorldOfDiaries\Callback;

use App\Entity\User;
use App\Services\Telegram\BaseCallback;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\WorldOfDiaries\Helper\Entity\UserHelper;
use Telegram\Bot\Objects\Message;
use Twig\Environment;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class WodBaseCallback extends BaseCallback
{
    protected User $user;

    public function __construct(
        TelegramLogger $logger,
        protected UserHelper $userHelper,
        protected Environment $templates,
        protected TranslatorInterface $textRes,
    ) {
        parent::__construct($logger);
    }

    protected function setUser(Message $data) {
        $this->user = $this->userHelper->initUser($data);
    }
}
