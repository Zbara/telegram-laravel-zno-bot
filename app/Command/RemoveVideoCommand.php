<?php

namespace App\Command;

use App\Models\TelegramVideos;
use App\Telegram\Callback;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\BaseObject;


class RemoveVideoCommand extends Command
{
    protected $name = 'remove-videos';

    public function handle()
    {
        if (Callback::getParams(1)) {
            $videos = TelegramVideos::where('id', Callback::getParams(1))->where('user_id', User::getUser()->id);

            if ($videos) {
                $videos->delete();

                RemoveMessages::remove();

                return $this->replyWithMessage([
                    'text' => 'Урок удален.',
                ]);
            }
        }
        return $this->replyWithMessage([
            'text' => 'Видео не найдено.',
        ]);
    }
}
