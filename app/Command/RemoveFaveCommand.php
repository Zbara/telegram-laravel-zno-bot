<?php

namespace App\Command;

use App\Models\Fave;
use App\Models\TelegramUsersDoneVideos;
use App\Models\TelegramVideos;
use App\Telegram\Callback;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\BaseObject;


class RemoveFaveCommand extends Command
{
    protected $name = 'remove-fave';

    public function handle()
    {
        if (Callback::getParams(1)) {
            $fave = Fave::find(Callback::getParams(1));

            if ($fave) {
                $fave->delete();

                RemoveMessages::remove();

                return $this->replyWithMessage([
                    'text' => 'Закладка удалена.',
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
        }
        return $this->replyWithMessage([
            'text' => 'Закладка не найдена.',
        ]);
    }
}
