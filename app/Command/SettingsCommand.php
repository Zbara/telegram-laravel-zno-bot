<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class SettingsCommand extends Command
{
    protected $name = 'settings';

    public function handle()
    {
        /** удаление старого сообщения */
        RemoveMessages::remove();
        $role = [];

        if (User::getUser()->role == 1) {
            $role = [
                'text' => 'Стать учителем',
                'id' => 2
            ];
        } elseif (User::getUser()->role == 2) {
            $role = [
                'text' => 'Стать учеником',
                'id' => 1
            ];
        }
        $line = [
            'inline_keyboard' => [
                [
                    ['text' => $role['text'], 'callback_data' => 'settings-role,' . $role['id']],
                ],
                [
                    ['text' => 'Главное меню', 'callback_data' => 'start'],
                ],
            ],
            'resize_keyboard' => true,
        ];

        if(User::getUser()->role == 2) {
            $line['inline_keyboard'][0][] = ['text' => 'Платежные данные', 'callback_data' => 'pay'];
        }

        $this->replyWithMessage([
            'text' => 'Настройки',
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make($line)
        ]);
    }
}
