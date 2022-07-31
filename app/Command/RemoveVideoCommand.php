<?php

namespace App\Command;

use App\Models\TelegramVideos;
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
        if ($callback = $this->getUpdate()->get('callback_query')) {
            $data = explode(',', $callback->get('data'));

            if (isset($data[1])) {
                $videos = TelegramVideos::where('id',  $data[1])->where('user_id', User::getUser()->id);

                if($videos) {

                    $videos->delete();

                    try {
                        $this->getTelegram()->deleteMessage(['message_id' => $callback->getMessage()->get('message_id'), 'chat_id' => $callback->getMessage()->chat->get('id')]);
                    } catch (TelegramSDKException $e) {
                        \Log::error($e->getMessage());
                    }

                    return $this->replyWithMessage([
                        'text' => 'Урок удален.',
                    ]);
                }
            }
        }
        return $this->replyWithMessage([
            'text' => 'Видео не найдено.',
        ]);
    }
}
