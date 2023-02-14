<?php

namespace App\Services\Telegram\Interface;

interface CommandContainerInterface
{
    public function getCommands() : array;
}