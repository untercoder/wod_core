<?php

namespace App\Services\Telegram\Interface;

interface CallbackContainerInterface
{
    public function getCallbacks(): array;

}