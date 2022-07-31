<?php

namespace App\Command;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;


class StartCommand extends Command
{
    protected $name = 'start';
    protected $aliases = ['restart'];
    protected $description = 'Приветственный текст.';

    public function handle()
    {
        $text = $this->description;

        $this->replyWithMessage(compact('text'));

        usleep(500);

        $this->replyWithMessage([
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
}
