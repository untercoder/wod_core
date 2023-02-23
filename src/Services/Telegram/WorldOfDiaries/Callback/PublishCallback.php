<?php

namespace App\Services\Telegram\WorldOfDiaries\Callback;

class PublishCallback extends WodBaseCallback
{

    private array $stages = ['validate', 'approved', 'public'];

    public function handle(): void
    {
        $this->setUser($this->update->message);

        $stage = ($this->action->getState())['stage'];
        try {
            if (in_array($stage, $this->stages)) {
                $response = match ($stage) {
                    'validate' => $this->validateAction(),
                    'approved' => $this->approveAction(),
                    'public' => $this->publicAction()
                };
                $this->sendMessageToUser($this->user, $response, $this->telegram);
            } else {
                throw new \Exception('Undefined stage in action ' . self::class);
            }
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }
    }

    private function validateAction(): string
    {
        //logic
        $this->action->setState(['stage' => 'approved']);
        $this->actionHelper->save($this->action);
        return 'Validate';
    }

    private function approveAction(): string
    {
        //logic
        $this->action->setState(['stage' => 'public']);
        $this->actionHelper->save($this->action);
        return 'Approve';
    }

    private function publicAction(): string
    {
        //logic
        $this->actionHelper->remove($this->action);
        return 'Public';
    }

}