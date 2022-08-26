<?php

namespace App\Command;

use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherCommand extends Command
{
    protected $name = 'teacher';
    protected $description = 'Вы выбрали роль учителя';

    public function __construct()
    {
        parent::setAliases([
            'Я - Учитель',
        ]);
    }

    public function handle()
    {
        /** удалаление старого сообщения */
        RemoveMessages::remove();

        $this->replyWithMessage([
            'text' => $this->description,
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => [
                    [
                        ['text' => 'Обществознание', 'callback_data' => 'teacher-items,1'],
                        ['text' => 'Алгебра', 'callback_data' => 'teacher-items,2'],
                        ['text' => 'Геометрия', 'callback_data' => 'teacher-items,3'],
                    ],
                    [
                        ['text' => 'Мои уроки', 'callback_data' => 'teacher-my'],
                        ['text' => 'Настройки', 'callback_data' => 'settings'],
                        ['text' => 'Помощь', 'callback_data' => 'help'],
                    ]
                ],
                'resize_keyboard' => true,
            ])
        ]);
        User::setRole(2);
        User::setVideo(null);
        User::setVideoUploads(null);
    }
}
