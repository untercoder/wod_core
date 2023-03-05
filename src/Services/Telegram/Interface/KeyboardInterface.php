<?php

namespace App\Services\Telegram\Interface;

interface KeyboardInterface
{
    public function getKeyboard() : array;
}