<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

use App\Entity\Actions;
use App\Entity\User;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\WorldOfDiaries\Helper\Entity\ActionHelper;
use App\Services\Telegram\WorldOfDiaries\Helper\Entity\UserHelper;
use App\Services\Telegram\WorldOfDiaries\Trait\MessageTrait;
use Symfony\Contracts\Translation\TranslatorInterface;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\Update;
use Twig\Environment;

abstract class BaseCommand extends Command
{
    use MessageTrait;

    protected User $user;

    protected Update $userCall;

    protected Actions|false $action;

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
            $this->logger->debug("REMOVE: " . json_encode($this->action, JSON_PRETTY_PRINT));
            $this->actionHelper->remove($this->action);
        }
    }
}