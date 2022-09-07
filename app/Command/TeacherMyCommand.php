<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Models\TelegramUsers;
use App\Models\TelegramVideos;
use App\Telegram\RemoveMessages;
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
        /** удалаление старого сообщения */
        RemoveMessages::remove();

        $videos = TelegramVideos::where('user_id', User::getUser()->id)->get();
        $count = TelegramVideos::where('user_id', User::getUser()->id)->count('*');
        $countViews = TelegramVideos::where('user_id', User::getUser()->id)->sum('views');

        if (count($videos) > 0) {
            $this->replyWithMessage([
                'text' => sprintf("Список моих уроков. \n\n Количество моих уроков: %s \n\n Общее количество просмотров моих уроков: %s" ,$count, $countViews),
                'chat_id' => $this->getUpdate()->getChat()->id,
                'reply_markup' => Keyboard::make([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Назад к урокам', 'callback_data' => 'teacher'],
                        ]
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
            foreach ($videos as $item) {
                if ($item->tags !== null) {

                    $this->replyWithVideo([
                        'caption' => sprintf("Видео по предмету - %s. \n\nТема - %s. \n\nТеги - %s. \n\nКоличество просмотров - %s просмотр.",
                            TextList::$items[$item->subject], $item->theme, $item->tags, (int) $item->views),
                        'video' => $item->file_name,
                        'chat_id' => $this->getUpdate()->getChat()->id,
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
            return $this->replyWithMessage([
                'text' => 'Вернуться назад',
                'chat_id' => $this->getUpdate()->getChat()->id,
                'reply_markup' => Keyboard::make([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Назад к урокам', 'callback_data' => 'teacher'],
                        ]
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
        }
        $this->replyWithMessage([
            'text' => 'Вы еще не создали ни одного урока.',
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => [
                    [
                        ['text' => 'Назад к урокам', 'callback_data' => 'teacher'],
                    ]
                ],
                'resize_keyboard' => true,
            ])
        ]);
    }
}
