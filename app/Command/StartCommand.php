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

    protected array $roles = [
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
                    'inline_keyboard' => [
                        [
                            ['text' => 'Я - Учитель', 'callback_data' => 'teacher'],
                            ['text' => 'Я - Ученик', 'callback_data' => 'student'],
                        ]
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
        }
        User::setStartCommand($this->roles[User::getUser()->role]);

        return $this->triggerCommand($this->roles[User::getUser()->role]);
    }
}
