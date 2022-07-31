<?php

namespace App\Command;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherVideosCommand extends Command
{
    protected $name = 'teacher-videos';

    private array $items = [
        'Загрузить видео',
    ];

    public function __construct()
    {
        parent::setAliases($this->items);
    }

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => 'Загрузка видео, от 5 до 30 секунд.',
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
