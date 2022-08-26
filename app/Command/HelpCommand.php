<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class HelpCommand extends Command
{
    protected $name = 'help';

    public function handle()
    {
        /** удаление старого сообщения */
        RemoveMessages::remove();

        $this->replyWithMessage([
            'text' => 'Помощь, что тут должно быть?',
            'chat_id' => $this->getUpdate()->getChat()->id,
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
