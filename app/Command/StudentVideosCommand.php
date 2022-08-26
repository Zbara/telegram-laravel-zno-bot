<?php

namespace App\Command;

use App\Command\Messages\Subject;
use App\Models\TelegramUsers;
use App\Models\TelegramUsersDoneVideos;
use App\Models\TelegramVideos;
use App\Telegram\Callback;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class StudentVideosCommand extends Command
{
    protected $name = 'student-videos';

    public function handle()
    {
        /** удалаление старого сообщения */
        RemoveMessages::remove();

        $subject = Subject::items(Callback::getParams(1));
        $videos = TelegramVideos::getVideo();

        if(isset($videos->id)) {

            $this->replyWithMessage([
                'text' => sprintf('Вы выбрали предмет - %s', $subject),
                'chat_id' => $this->getUpdate()->getChat()->id,
            ]);

            $this->replyWithVideo([
                'caption' => sprintf('Тема - %s. %s%s.', $videos->theme, "\n\n", $videos->tags),
                'video' => $videos->file_name,
                'reply_markup' => Keyboard::make([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Понял', 'callback_data' => 'student-videos-answer,success'],
                            ['text' => 'Не понял', 'callback_data' => 'student-videos-answer,error'],
                        ],
                        [
                            ['text' => 'Добавить в закладки', 'callback_data' => 'faveAdd,' . $videos->id ],
                        ],
                        [
                            ['text' => 'Назад к урокам', 'callback_data' => 'student'],
                        ],
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
            return;
        }

        $this->replyWithMessage([
            'text' => 'Вы прошли все видео по этому предмету.',
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => [
                    [
                        ['text' => 'Назад к урокам', 'callback_data' => 'student'],
                    ],
                ],
                'resize_keyboard' => true,
            ])
        ]);
    }
}
