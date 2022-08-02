<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Models\TelegramVideos;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherVideosUsersCommand extends Command
{
    protected $name = 'teacher-videos-users';

    public function handle()
    {
        /** удалаление старого сообщения */
        RemoveMessages::remove();

        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $videos = TelegramVideos::where('subject', User::getUser()->subject)->get();

        if (count($videos) > 0) {
            $this->replyWithMessage([
                'text' => 'Видео пользователей',
                'chat_id' => $this->getUpdate()->getChat()->id,
            ]);
            foreach ($videos as $item) {
                if ($item->tags !== null) {
                    $this->replyWithVideo([
                        'caption' => sprintf('Видео по предмету - %s. %sТема - %s. %sТеги - %s.', TextList::$items[$item->subject], "\n\n", $item->theme, "\n\n", $item->tags),
                        'video' => $item->file_name,
                    ]);
                    usleep(1000);
                }
            }
            return $this->replyWithMessage([
                'text' => 'Вернуться назад',
                'chat_id' => $this->getUpdate()->getChat()->id,
                'reply_markup' => Keyboard::make([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Назад к предмету', 'callback_data' => 'teacher-items, ' . User::getUser()->subject],
                        ]
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
        }
        $this->replyWithMessage([
            'text' => 'Видео не найдено.',
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => [
                    [
                        ['text' => 'Назад к предмету', 'callback_data' => 'teacher-items, ' . User::getUser()->subject],
                    ]
                ],
                'resize_keyboard' => true,
            ])
        ]);
    }
}
