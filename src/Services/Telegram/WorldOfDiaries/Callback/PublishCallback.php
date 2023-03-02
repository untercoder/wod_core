<?php

namespace App\Services\Telegram\WorldOfDiaries\Callback;

use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\WorldOfDiaries\Helper\Entity\ActionHelper;
use App\Services\Telegram\WorldOfDiaries\Helper\Entity\PostHelper;
use App\Services\Telegram\WorldOfDiaries\Helper\Entity\UserHelper;
use App\Services\Telegram\WorldOfDiaries\Helper\Keyboard\EditKeyboard;
use App\Services\Telegram\WorldOfDiaries\Helper\Keyboard\KeyboardHelper;
use Doctrine\DBAL\Exception;
use Symfony\Contracts\Translation\TranslatorInterface;
use Telegram\Bot\Objects\Message;
use Twig\Environment;

class PublishCallback extends WodBaseCallback
{
    public const NEW_POST_STAGE = 'new_post';

    public const UPDATE_POST_STAGE = 'update_post';

    public const APPROVE_STAGE_FROM_NEW_POST = 'approve_new';

    public const APPROVE_STAGE_FROM_UPDATE_POST = 'approve_update';

    public const APPROVE_STAGE_FROM_START_UPDATE = 'approve_start_update';

    public const MODERATION_STAGE = 'moderation';

    public function __construct(
        TelegramLogger $logger,
        UserHelper $userHelper,
        Environment $templates,
        TranslatorInterface $textRes,
        ActionHelper $actionHelper,
        private PostHelper $postHelper,
        private KeyboardHelper $keyboardHelper
    ) {
        parent::__construct($logger, $userHelper, $templates, $textRes, $actionHelper);
    }


    private array $stages = [
        self::NEW_POST_STAGE,
        self::UPDATE_POST_STAGE,
        self::MODERATION_STAGE,
        self::APPROVE_STAGE_FROM_UPDATE_POST,
        self::APPROVE_STAGE_FROM_NEW_POST,
        self::APPROVE_STAGE_FROM_START_UPDATE
    ];

    public function handle(): void
    {
        if ($this->message !== null) {
            $this->setUser($this->message);
        }

        if ($this->callback !== null) {
            $this->setUser($this->callback->message);
        }

        $stage = ($this->action->getState())['stage'];

        try {
            if ($this->validateStage($stage)) {
                match ($stage) {
                    self::NEW_POST_STAGE => $this->newPostAction(),
                    self::UPDATE_POST_STAGE => $this->updatePostAction(),
                    self::APPROVE_STAGE_FROM_NEW_POST => $this->approveAction(),
                    self::APPROVE_STAGE_FROM_UPDATE_POST => $this->approveAction(),
                    self::APPROVE_STAGE_FROM_START_UPDATE => $this->approveAction(false)
                };
            }
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }
    }


    private function newPostAction(): Message|Exception
    {
        if ($this->message !== null) {
            $message = $this->validateMessages($this->message);

            if ($message) {

                $newPostOkMessage = $this->textRes->trans('callback.publish.new_post_ok', [], 'message', 'ru');

                $this->sendMessageToUserTemplate(
                    $this->user,
                    $newPostOkMessage,
                    $this->telegram
                );

                $post = $this->postHelper->createPost($message, $this->user);

                $this->switchStage(self::APPROVE_STAGE_FROM_NEW_POST);

                return $this->sendPostToUserWithKeyboard(
                    $this->user,
                    $post,
                    $this->telegram,
                    $this->keyboardHelper->createEditKeyboard()
                );
            }
            throw new \Exception(
                'Create post not validated User: ' . json_encode($this->user, JSON_PRETTY_PRINT) . " " . self::class
            );
        }

        throw new Exception('Create post error ' . self::class);
    }

    private function updatePostAction(): Message|Exception
    {
        if ($this->message !== null) {
            $message = $this->validateMessages($this->message);
            if ($message) {
                $post = $this->postHelper->findPost($this->user);

                $post->setPostId($this->message->messageId);

                $this->userHelper->save($post);

                $updatePostOkMessage = $this->textRes->trans('callback.publish.update_post_ok', [], 'message', 'ru');

                $this->sendMessageToUserTemplate(
                    $this->user,
                    $updatePostOkMessage,
                    $this->telegram
                );

                $this->switchStage(self::APPROVE_STAGE_FROM_UPDATE_POST);

                return $this->sendPostToUserWithKeyboard(
                    $this->user,
                    $post,
                    $this->telegram,
                    $this->keyboardHelper->createEditKeyboard()
                );
            }
            throw new \Exception(
                'Update post not validated User: ' . json_encode($this->user, JSON_PRETTY_PRINT) . " " . self::class
            );
        }

        throw new \Exception('Update post error ' . self::class);
    }

    private function approveAction(bool $update = true): Message|Exception
    {
        if ($this->callback !== null) {
            if ($this->callback->data === EditKeyboard::CALLBACK_DATA_YES) {
                if ($update) {
                    return $this->moderate();
                }

                $this->actionHelper->remove($this->action);

                $notUpdateMessage = $this->textRes->trans('callback.publish.approve.not_update', [], 'message', 'ru');

                return $this->sendMessageToUserTemplate(
                    $this->user,
                    $notUpdateMessage,
                    $this->telegram
                );
            }

            $this->switchStage(self::UPDATE_POST_STAGE);

            $setUpdateMessage = $this->textRes->trans('callback.publish.approve.set_update', [], 'message', 'ru');

            return $this->sendMessageToUserTemplate(
                $this->user,
                $setUpdateMessage,
                $this->telegram
            );
        }

        throw new \Exception('Approve new post error ' . self::class);
    }

    private function moderate(): Message
    {
        $this->switchStage(self::MODERATION_STAGE);
        //Go moderate
        $this->actionHelper->remove($this->action);

        $moderateMessage = $this->textRes->trans('callback.publish.moderate', [], 'message', 'ru');

        return $this->sendMessageToUserTemplate(
            $this->user,
            $moderateMessage,
            $this->telegram
        );
    }

    private function validateMessages(Message $message): Message|false
    {
        if ($message->caption !== null || $message->text !== null) {
            $text = $message->caption === null ? $message->text : $message->caption;
            if (strpos($text, 'https://t.me/')) {
                return $message;
            }
        }

        if ($message->mediaGroupId === null) {

            $invalidMessage = $this->textRes->trans('callback.publish.post_invalid', [], 'message', 'ru');

            $this->sendMessageToUserTemplate(
                $this->user,
                $invalidMessage,
                $this->telegram
            );
        }

        return false;
    }

    private function switchStage(string $stage)
    {
        $this->validateStage($stage);
        $this->action->setState(['stage' => $stage]);
        $this->actionHelper->save($this->action);
    }

    private function validateStage(string $stage): bool
    {
        try {
            if (!in_array($stage, $this->stages)) {
                throw new \Exception('Undefined stage in action ' . self::class);
            }
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage());
            return false;
        }

        return true;
    }
}