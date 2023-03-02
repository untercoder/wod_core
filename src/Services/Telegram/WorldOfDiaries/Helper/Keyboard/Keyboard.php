<?php

namespace App\Services\Telegram\WorldOfDiaries\Helper\Keyboard;

use App\Services\Telegram\Interface\KeyboardInterface;

abstract class Keyboard implements KeyboardInterface
{
    protected array $keyboard = [];


    public function getKeyboard(): array
    {
        return $this->keyboard;
    }
}