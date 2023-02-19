<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;


use App\Services\Telegram\BaseCommand;

class HelpCommand extends WodCommand
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
        $this->replyWithMessage([
            'text' => $this->textRes->trans('commands.help.list', [], 'message', 'ru'),
            'parse_mode' => 'HTML'
        ]);
    }
}