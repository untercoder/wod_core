<?php

namespace App\Services\Telegram\Admin\Command;

use App\Entity\Action;
use App\Entity\Moderator;
use App\Helper\Entity\ActionHelper;
use App\Helper\Entity\UserHelper;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Trait\MessageTrait;
use Symfony\Contracts\Translation\TranslatorInterface;
use Telegram\Bot\Commands\Command;
use Twig\Environment;

abstract class BaseAdminCommand extends Command
{
    use MessageTrait;

    protected Moderator $moderator;

    protected Action|false $action;

    public function __construct(
        protected TranslatorInterface $textRes,
        protected TelegramLogger $logger,
        protected Environment $template,
        protected ActionHelper $actionHelper
    )
    {
    }

    public function initCommand() : void {
        //Авторизация модера
    }
}