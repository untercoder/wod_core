<?php

namespace App\Services\Telegram\WorldOfDiaries\Command;

use App\Helper\Entity\ActionHelper;
use App\Helper\Entity\PostHelper;
use App\Helper\Entity\UserHelper;
use App\Helper\Keyboard\KeyboardHelper;
use App\Services\Telegram\Logger\TelegramLogger;
use App\Services\Telegram\WorldOfDiaries\Callback\PublishCallback;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class PublishPostWodCommand extends BaseWodCommand
{
    public function __construct(
        TranslatorInterface $textRes,
        TelegramLogger $logger,
        UserHelper $userHelper,
        Environment $template,
        ActionHelper $actionHelper,
        private PostHelper $postHelper,
        private KeyboardHelper $keyboardHelper

    ) {
        parent::__construct(
            $textRes,
            $logger,
            $userHelper,
            $template,
            $actionHelper
        );
    }


    /**
     * @var string Command Name
     */
    protected $name = "publish";

    /**
     * @var string Command Description
     */
    protected $description = "Создать пост";

    public function handle()
    {
        $this->initCommand();

        $action = $this->actionHelper->make($this->userCall->message);

        $action->setType($this->actionHelper::PUBlISH_ACTION);

        $action->setUserId($this->user->getId());

        $post = $this->postHelper->findPost($this->user);

        if ($post) {

            $postExistMessage = $this->textRes->trans('commands.publish.post_exist', [], 'message', 'ru');

            $this->sendMessageToUserTemplate(
                $this->user,
                $postExistMessage,
                $this->telegram
            );

            $keyboard = $this->keyboardHelper->createEditKeyboard();

            $this->sendPostToUserWithKeyboard(
                $this->user,
                $post,
                $this->telegram,
                $keyboard
            );

            $action->setState(["stage" => PublishCallback::APPROVE_STAGE_FROM_START_UPDATE]);
        } else {

            $action->setState(["stage" => PublishCallback::NEW_POST_STAGE]);

            $postExistMessage = $this->textRes->trans('commands.publish.new_post_information', [], 'message', 'ru');

            $this->sendMessageToUserTemplate(
                $this->user,
                $postExistMessage,
                $this->telegram
            );
        }

        $this->actionHelper->save($action);
    }
}