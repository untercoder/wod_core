<?php

namespace App\Services\Telegram\Interface;

use App\Services\Telegram\WorldOfDiaries\Helper\Keyboard\Keyboard;

interface KeyboardInterface
{
    public function getKeyboard() : array;
}