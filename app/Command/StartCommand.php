<?php

namespace App\Command;

use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;


class StartCommand extends Command
{
    protected $name = 'start';
    protected $aliases = ['restart'];
    protected $description = 'Приветственный текст.';

    protected $roles = [
        1 => 'student',
        2 => 'teacher'
    ];

    public function handle()
    {
        if (User::getUser()->role == 0) {
            $text = $this->description;

            $this->replyWithMessage(compact('text'));

            usleep(500);

            return $this->replyWithMessage([
                'text' => 'Доброе время суток,выберите кто Вы?',
                'chat_id' => $this->getUpdate()->getChat()->id,
                'reply_markup' => Keyboard::make([
                    'keyboard' => [
                        [
                            'Я - Учитель',
                            'Я - Ученик',
                        ],
                    ],
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true,
                ])
            ]);
        }
        User::setStartCommand($this->roles[User::getUser()->role]);

        return $this->triggerCommand($this->roles[User::getUser()->role]);
    }
}
