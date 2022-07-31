<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class StudentCommand extends Command
{
    protected $name = 'student';
    protected $description = 'Вы выбрали роль ученика';

    public function __construct()
    {
        parent::setAliases([
            'Я - Ученик',
        ]);
    }

    public function handle()
    {
        $this->replyWithMessage([
            'text' => $this->description,
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'keyboard' => [
                    TextList::$items
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => false,
            ])
        ]);
        User::setRole(1);
    }
}
