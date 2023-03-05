<?php

namespace App\Services\Telegram\WorldOfDiaries\Callback;

use App\Entity\User;
use App\Helper\Entity\ActionHelper;
use App\Helper\Entity\UserHelper;
use App\Services\Telegram\BaseCallback;
use App\Services\Telegram\Logger\TelegramLogger;
use Symfony\Contracts\Translation\TranslatorInterface;
use Telegram\Bot\Objects\Message;
use Twig\Environment;


abstract class WodBaseCallback extends BaseCallback
{
    protected User $user;

    public function __construct(
        TelegramLogger $logger,
        protected UserHelper $userHelper,
        protected Environment $templates,
        protected TranslatorInterface $textRes,
        protected ActionHelper $actionHelper
    ) {
        parent::__construct($logger);
    }

    protected function setUser(Message $data) {
        $this->user = $this->userHelper->initUser($data);
    }
}
