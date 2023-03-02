<?php

namespace App\Services\Telegram\WorldOfDiaries\Helper\Keyboard;

use Symfony\Contracts\Translation\TranslatorInterface;

class KeyboardHelper
{


    public function __construct(
        private TranslatorInterface $textRes
    )
    {
    }

    public function createEditKeyboard() : Keyboard {
        return new EditKeyboard($this->textRes);
    }
}