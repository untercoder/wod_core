<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Entity\Actions;
use App\Services\Telegram\Interface\CallbackInterface;
use App\Services\Telegram\WorldOfDiaries\Helper\Entity\ActionHelper;

class CallbackObserver
{

    public function __construct(private WodCallbackContainer $callbackContainer)
    {
    }

    public function callbackFactory(Actions|false $action): CallbackInterface
    {
        if ($action) {
            $actionType = $action->getType();
            return match ($actionType) {
                ActionHelper::VIEW_ACTION => $this->callbackContainer->getViewCallback(),
                ActionHelper::PUBlISH_ACTION => $this->callbackContainer->getPublishCallback()
            };
        }

        return $this->callbackContainer->getDontUnderstandCallback();
    }
}