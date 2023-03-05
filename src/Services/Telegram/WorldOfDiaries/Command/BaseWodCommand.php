<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

use App\Entity\Action;
use App\Entity\User;
use App\Helper\Entity\ActionHelper;
use App\Helper\Entity\UserHelper;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Trait\MessageTrait;
use Symfony\Contracts\Translation\TranslatorInterface;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\Update;
use Twig\Environment;

abstract class BaseWodCommand extends Command
{
    use MessageTrait;

    protected User $user;

    protected Update $userCall;

    protected Action|false $action;

    public function __construct(
        protected TranslatorInterface $textRes,
        protected TelegramLogger $logger,
        protected UserHelper $userHelper,
        protected Environment $template,
        protected ActionHelper $actionHelper
    ) {
    }

    public function initCommand(): void
    {
        $this->userCall = $this->telegram->getWebhookUpdate();
        $this->user = $this->userHelper->initUser($this->userCall->message);
        $this->action = $this->actionHelper->getActiveAction($this->user->getChatId());

        if ($this->action) {
            $this->actionHelper->remove($this->action);
        }
    }
}