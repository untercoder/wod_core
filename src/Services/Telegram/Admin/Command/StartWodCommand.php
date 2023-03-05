<?php

namespace App\Services\Telegram\Admin\Command;

use App\Trait\MessageTrait;

class StartWodCommand extends BaseAdminCommand
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";
    public function handle()
    {
       $this->sendMessageToTemplate($this->update->message->from->id, 'Привет я админка!', $this->telegram);
    }
}