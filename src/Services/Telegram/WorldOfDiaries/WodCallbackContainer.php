<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Services\Telegram\Interface\CallbackContainerInterface;
use App\Services\Telegram\WorldOfDiaries\Callback\DontUnderstandCallback;

use App\Services\Telegram\WorldOfDiaries\Callback\PublishCallback;
use App\Services\Telegram\WorldOfDiaries\Callback\ViewCallback;

use function Symfony\Component\Translation\t;

class WodCallbackContainer implements CallbackContainerInterface
{

    public function __construct(
        private readonly DontUnderstandCallback $dontUnderstandCallback,
        private readonly ViewCallback $viewCallback,
        private readonly PublishCallback $publishCallback
    ) {
    }

    public function getCallbacks(): array
    {
        return [
            $this->dontUnderstandCallback,
            $this->publishCallback,
            $this->viewCallback
        ];
    }

    public function getDontUnderstandCallback(): DontUnderstandCallback
    {
        return $this->dontUnderstandCallback;
    }


    public function getViewCallback(): ViewCallback
    {
        return $this->viewCallback;
    }

    public function getPublishCallback(): PublishCallback
    {
        return $this->publishCallback;
    }


}