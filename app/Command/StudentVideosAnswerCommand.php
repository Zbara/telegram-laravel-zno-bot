<?php

namespace App\Command;

use App\Models\TelegramUsersDoneVideos;
use App\Models\TelegramVideos;
use App\Telegram\Callback;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class StudentVideosAnswerCommand extends Command
{
    protected $name = 'student-videos-answer';

    public function handle()
    {
        /** удалаление старого сообщения */
        RemoveMessages::remove();

        switch (Callback::getParams(1)){
            /** ответ понял */
            case 'success':
                TelegramUsersDoneVideos::create([
                    'user_id' => User::getUser()->id,
                    'video_id' => User::getUser()->video_id,
                    'status' => 1,
                ]);
                $this->sendNewVideo();
                break;
            /** ответ не понял */
            case 'error':
                TelegramUsersDoneVideos::create([
                    'user_id' => User::getUser()->id,
                    'video_id' => User::getUser()->video_id,
                    'status' => 0,
                ]);

                $this->sendNewVideo();
                break;

            default:

                $this->replyWithMessage([
                    'text' => 'Такого ответа нет.',
                ]);
        }
    }

    private function sendNewVideo(): void
    {
        $videos = TelegramVideos::getVideo();

        if(isset($videos->id)) {
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
            'text' => 'Видео больше не найдено.',
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
