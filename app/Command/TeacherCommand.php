<?php

namespace App\Command;

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
        $this->replyWithMessage([
            'text' => $this->description,
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'keyboard' => [
                    [
                        'Обществознание',
                        'Алгебра',
                        'Геометрия',
                    ],
                    [
                        'Мои уроки'
                    ]
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ])
        ]);
        User::setRole(2);
    }
}
