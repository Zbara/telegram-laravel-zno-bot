<?php

namespace App\Command;

use App\Models\TelegramUsers;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherItemsCommand extends Command
{
    protected $name = 'teacher-items';

    private array $items = [
        'Обществознание',
        'Алгебра',
        'Геометрия',
    ];

    public function __construct()
    {
        parent::setAliases($this->items);
    }

    private function subject()
    {
        $user = TelegramUsers::where('platform_id', $this->getUpdate()->getChat()->id)->first();

        if (array_search($this->getUpdate()->getMessage()->text, $this->items) !== null) {
            $user->subject = array_search($this->getUpdate()->getMessage()->text, $this->items);
            $user->save();
        }
        return (isset($this->items[$user->subject])) ? $this->items[$user->subject] : 'Не известно.';
    }

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage([
            'text' => sprintf('Вы выбрали предмет - %s',  $this->subject()),
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
