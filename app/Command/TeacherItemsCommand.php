<?php

namespace App\Command;

use App\Command\Messages\Subject;
use App\Command\Messages\TextList;
use App\Models\TelegramUsers;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherItemsCommand extends Command
{
    protected $name = 'teacher-items';

    public function __construct()
    {
        parent::setAliases(TextList::$items);
    }

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => sprintf('Вы выбрали предмет - %s',  Subject::items($this->getUpdate()->getMessage()->text)),
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'keyboard' => [
                    [
                        'Загрузить видео',
                        'Видео других пользователей',
                    ],
                    [
                        'Назад к урокам'
                    ]
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ])
        ]);
    }
}
