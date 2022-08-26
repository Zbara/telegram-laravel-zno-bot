<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Models\Fave;
use App\Models\TelegramVideos;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class FaveCommand extends Command
{
    protected $name = 'fave';

    public function handle()
    {

        $fave = Fave::where('user_id', User::getUser()->id)->get();

        if (count($fave) > 0) {
            $this->replyWithMessage([
                'text' => 'Список моих закладок',
                'chat_id' => $this->getUpdate()->getChat()->id,
                'reply_markup' => Keyboard::make([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Назад к урокам', 'callback_data' => 'student'],
                        ]
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
            foreach ($fave as $item) {
                if($item->videos) {
                    $this->replyWithVideo([
                        'caption' => sprintf('Видео по предмету - %s. %sТема - %s. %sТеги - %s.', TextList::$items[$item->videos->value('subject')], "\n\n", $item->videos->value('theme'), "\n\n", $item->videos->value('tags')),
                        'video' => $item->videos->value('file_name'),
                        'chat_id' => $this->getUpdate()->getChat()->id,
                        'reply_markup' => Keyboard::make([
                            'inline_keyboard' => [
                                [
                                    ['text' => 'Удалить закладку', 'callback_data' => 'remove-fave,' . $item->id],
                                ]
                            ],
                            'resize_keyboard' => true,
                        ]),
                    ]);
                }
                usleep(1000);
            }
            return $this->replyWithMessage([
                'text' => 'Вернуться назад',
                'chat_id' => $this->getUpdate()->getChat()->id,
                'reply_markup' => Keyboard::make([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Назад к урокам', 'callback_data' => 'student'],
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
