<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class PaymentsSaveCommand extends Command
{
    protected $name = 'pay-save';

    public function handle()
    {
        $text = $this->getUpdate()->getMessage()->text;

        if (mb_strlen($text) >= 5 and mb_strlen($text) <= 30) {
            User::getUser()->payments = $text;
            User::getUser()->save();

            return $this->replyWithMessage([
                'text' => 'Сохраненно',
                'reply_markup' => Keyboard::make([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Главное меню', 'callback_data' => 'start'],
                        ],
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
        }
        return $this->replyWithMessage([
            'text' => 'Введите название данные.',
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => [
                    [
                        ['text' => 'Главное меню', 'callback_data' => 'start'],
                    ],
                ],
                'resize_keyboard' => true,
            ])
        ]);
    }
}
