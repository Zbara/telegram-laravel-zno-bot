<?php

namespace App\Command;

use App\Command\Messages\Subject;
use App\Models\TelegramUsers;
use App\Models\TelegramUsersDoneVideos;
use App\Models\TelegramVideos;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class StudentVideosCommand extends Command
{
    protected $name = 'student-videos';

    public function handle()
    {
        $subject = Subject::items($this->getUpdate()->getMessage()->text);
        $videos = TelegramVideos::getVideo();

        if(isset($videos->id)) {

            $this->replyWithMessage([
                'text' => sprintf('Вы выбрали предмет - %s', $subject),
                'chat_id' => $this->getUpdate()->getChat()->id,
                'reply_markup' => Keyboard::make([
                    'keyboard' => [
                        [
                            'Понял',
                            'Не понял'
                        ],
                        [
                            'Назад к урокам'
                        ]
                    ],
                    'resize_keyboard' => true,
                    'one_time_keyboard' => false,
                ])
            ]);

            $this->replyWithVideo([
                'caption' => sprintf('Тема - %s. %s%s.', $videos->theme, "\n\n", $videos->tags),
                'video' => $videos->file_name,
            ]);
            return;
        }

        $this->replyWithMessage([
            'text' => 'Вы прошли все видео по этому предмету.',
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'keyboard' => [
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
