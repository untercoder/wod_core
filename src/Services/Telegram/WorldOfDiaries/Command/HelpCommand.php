<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

use Telegram\Bot\Commands\Command;

class HelpCommand extends Command
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
        $this->replyWithMessage(['text' => 'Hello! Im Help Command!']);
    }
}