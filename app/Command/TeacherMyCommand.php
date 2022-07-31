<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Models\TelegramUsers;
use App\Models\TelegramVideos;
use App\Telegram\User;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class TeacherMyCommand extends Command
{
    protected $name = 'teacher-my';

    public function __construct()
    {
        parent::setAliases([
            'Мои уроки',
        ]);
    }

    public function handle()
    {
        $videos = TelegramVideos::where('user_id', User::getUser()->id)->get();

        if(count($videos) > 0) {
            $this->replyWithMessage([
                'text' => 'Список моих уроков',
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

            foreach ($videos as $item) {
                if ($item->tags !== null) {
                    $this->replyWithVideo([
                        'caption' => sprintf('Видео по предмету - %s. %sТема - %s. %sТеги - %s.', TextList::$items[$item->subject], "\n\n", $item->theme, "\n\n", $item->tags),
                        'video' => $item->file_name,
                        'reply_markup' => Keyboard::make([
                            'inline_keyboard' => [
                                [
                                    ['text' => 'Удалить урок', 'callback_data' => 'remove-videos,' . $item->id],
                                ]
                            ],
                            'resize_keyboard' => true,
                        ]),
                    ]);
                    usleep(1000);
                }
            }
            return;
        }
        $this->replyWithMessage([
            'text' => 'Вы еще не создали ни одного урока.',
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
