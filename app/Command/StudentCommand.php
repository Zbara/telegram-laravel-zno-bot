<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class StudentCommand extends Command
{
    protected $name = 'student';
    protected $description = 'Вы выбрали роль ученика';

    public function handle()
    {
        /** удаление старого сообщения */
        RemoveMessages::remove();

        $this->replyWithMessage([
            'text' => $this->description,
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => [
                    [
                        ['text' => 'Обществознание', 'callback_data' => 'student-videos,1'],
                        ['text' => 'Алгебра', 'callback_data' => 'student-videos,2'],
                        ['text' => 'Геометрия', 'callback_data' => 'student-videos,3'],
                    ],
                ],
                'resize_keyboard' => true,
            ])
        ]);
        User::setRole(1);
    }
}
