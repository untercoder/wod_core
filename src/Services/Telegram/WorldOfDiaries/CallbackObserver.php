<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\Interface\CallbackInterface;

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