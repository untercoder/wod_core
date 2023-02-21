<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\Interface\CallbackContainerInterface;
use App\Services\Telegram\WorldOfDiaries\Callback\DontUnderstandCallback;

use function Symfony\Component\Translation\t;

class WodCallbackContainer implements CallbackContainerInterface
{

    public function __construct(
        private readonly DontUnderstandCallback $dontUnderstandCallback,
    )
    {
    }

    public function getCallbacks(): array
    {
        return [
            $this->dontUnderstandCallback,
        ];
    }

    public function getDontUnderstandCallback(): DontUnderstandCallback
    {
        return $this->dontUnderstandCallback;
    }

}