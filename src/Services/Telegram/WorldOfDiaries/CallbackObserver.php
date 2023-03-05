<?php

namespace App\Services\Telegram\WorldOfDiaries;

use App\Entity\Action;
use App\Helper\Entity\ActionHelper;
use App\Services\Telegram\Interface\CallbackInterface;

class CallbackObserver
{

    public function __construct(private WodCallbackContainer $callbackContainer)
    {
    }

    public function callbackFactory(Action|false $action): CallbackInterface
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