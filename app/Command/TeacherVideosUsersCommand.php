<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Models\TelegramVideos;
use App\Telegram\User;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherVideosUsersCommand extends Command
{
    protected $name = 'teacher-videos-users';


    public function __construct()
    {
        parent::setAliases([
            'Видео других пользователей',
        ]);
    }

    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $videos = TelegramVideos::where('subject', User::getUser()->subject)->get();

        if(count($videos) > 0) {
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
            foreach ($videos as $item) {
                if ($item->tags !== null) {
                    $this->replyWithVideo([
                        'caption' => sprintf('Видео по предмету - %s. %sТема - %s. %sТеги - %s.', TextList::$items[$item->subject], "\n\n", $item->theme, "\n\n", $item->tags),
                        'video' => $item->file_name,
                    ]);
                    usleep(1000);
                }
            }
            return;
        }
        $this->replyWithMessage([
            'text' => 'Видео не найдено.',
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