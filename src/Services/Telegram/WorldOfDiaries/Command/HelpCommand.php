<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;


use App\Services\Telegram\BaseCommand;

class HelpCommand extends BaseCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "help";

    /**
     * @var string Command Description
     */
    protected $description = "My new help command!";

    public function handle()
    {
        $this->logger->info('Я из хелпа.');
        $this->replyWithMessage(['text' => $this->textRes->trans('help.commands', [], 'message', 'ru')]);
    }
}