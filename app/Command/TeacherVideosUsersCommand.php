<?php

namespace App\Command;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherVideosUsersCommand extends Command
{
    protected $name = 'teacher-videos-users';

    private array $items = [
        'Видео других пользователей',
    ];

    public function __construct()
    {
        parent::setAliases($this->items);
    }

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => 'Видео пользователей',
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'keyboard' => [
                    [
                        'Назад к предмету'
                    ]
                ],
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
            ])
        ]);
    }
}
