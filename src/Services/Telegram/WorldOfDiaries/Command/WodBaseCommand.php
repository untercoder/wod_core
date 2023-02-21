<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

use App\Entity\User;
use App\Services\Telegram\BaseCommand;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\WorldOfDiaries\Helper\Entity\UserHelper;
use App\Services\Telegram\WorldOfDiaries\Trait\MessageTrait;
use Symfony\Contracts\Translation\TranslatorInterface;
use Telegram\Bot\Objects\Message;
use Twig\Environment;

abstract class WodBaseCommand extends BaseCommand
{
    use MessageTrait;

    protected User $user;

    public function __construct(
        protected TranslatorInterface $textRes,
        protected TelegramLogger $logger,
        protected UserHelper $userHelper,
        protected Environment $template
    ) {
        parent::__construct($this->textRes, $this->logger);
    }

    protected function setUser(Message $message)
    {
        $this->user = $this->userHelper->initUser($message);
    }
}