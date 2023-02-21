<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\Interface\CallbackInterface;
use App\Services\Telegram\WorldOfDiaries\Callback\DontUnderstandCallback;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class CallbackObserver
{

    public function __construct(private WodCallbackContainer $callbackContainer)
    {
    }

    public function callbackFactory() : CallbackInterface
    {
        $callback = $this->callbackContainer->getDontUnderstandCallback();
        return $callback;
    }
}