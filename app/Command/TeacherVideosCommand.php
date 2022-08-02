<?php

namespace App\Command;

use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherVideosCommand extends Command
{
    protected $name = 'teacher-videos';

    public function handle()
    {
        /** удалаление старого сообщения */
        RemoveMessages::remove();

        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => 'Загрузка видео, от 5 до 30 секунд.',
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => [
                    [
                        ['text' => 'Назад к предмету', 'callback_data' => 'teacher-items,' . User::getUser()->subject],
                    ]
                ],
                'resize_keyboard' => true,
            ])
        ]);
    }
}
