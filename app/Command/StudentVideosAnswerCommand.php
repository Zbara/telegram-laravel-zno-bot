<?php

namespace App\Command;

use App\Models\TelegramUsersDoneVideos;
use App\Models\TelegramVideos;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class StudentVideosAnswerCommand extends Command
{
    protected $name = 'student-videos-answer';

    public function handle()
    {
        $text = $this->getUpdate()->getMessage()->text;

        switch ($text){
            case 'Понял':
                TelegramUsersDoneVideos::create([
                    'user_id' => User::getUser()->id,
                    'video_id' => User::getUser()->video_id,
                    'status' => 1,
                ]);
                $this->sendNewVideo();
                break;
            case 'Не понял':
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
            ]);
            return;
        }
        $this->replyWithMessage([
            'text' => 'Видео больше не найдено.',
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
