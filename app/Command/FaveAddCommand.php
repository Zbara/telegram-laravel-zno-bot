<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Models\Fave;
use App\Telegram\Callback;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class FaveAddCommand extends Command
{
    protected $name = 'faveAdd';

    public function handle()
    {
        if (Callback::getParams(1)) {
            $fave = Fave::where('user_id', User::getUser()->id)->where('video_id', Callback::getParams(1))->get();

            if ($fave->isEmpty()) {
                $faveAdd = new Fave();
                $faveAdd->video_id = Callback::getParams(1);
                $faveAdd->user_id = User::getUser()->id;
                $faveAdd->save();

                return $this->replyWithMessage([
                    'text' => 'Видео добавленно в закладки',
                    'chat_id' => $this->getUpdate()->getChat()->id,
                ]);
            }
        }
        return $this->replyWithMessage([
            'text' => 'Похоже что видео в закладках',
        ]);
    }
}
