<?php

namespace App\Command;

use App\Command\Messages\Subject;
use App\Command\Messages\TextList;
use App\Models\TelegramUsers;
use App\Telegram\Callback;
use App\Telegram\RemoveMessages;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherItemsCommand extends Command
{
    protected $name = 'teacher-items';

    public function handle()
    {
        /** удалаление старого сообщения */
        RemoveMessages::remove();

        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => sprintf('Вы выбрали предмет - %s',  Subject::items(Callback::getParams(1))),
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => [
                    [
                        ['text' => 'Загрузить видео', 'callback_data' => 'teacher-videos'],
                        ['text' => 'Видео других пользователей', 'callback_data' => 'teacher-videos-users'],
                    ],
                    [
                        ['text' => 'Назад к урокам', 'callback_data' => 'teacher'],
                    ]
                ],
                'resize_keyboard' => true,
            ])
        ]);
    }
}
