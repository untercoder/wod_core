<?php

namespace App\Helper\Keyboard;

use Symfony\Contracts\Translation\TranslatorInterface;

class EditKeyboard extends Keyboard
{
    public const CALLBACK_DATA_YES = 'yes';

    public const CALLBACK_DATA_NO = 'no';

    public function __construct(
        private TranslatorInterface $textRes,
    ) {
        $this->keyboard = [
            'inline_keyboard' => [
                [
                    [
                        "text" => $this->textRes->trans('keyboard.edit.confirm', [], 'message', 'ru'),
                        "callback_data" => self::CALLBACK_DATA_YES
                    ],

                ],
                [
                    [
                        "text" => $this->textRes->trans('keyboard.edit.cancel', [], 'message', 'ru'),
                        "callback_data" => self::CALLBACK_DATA_NO
                    ],
                ]
            ]
        ];
    }

}
