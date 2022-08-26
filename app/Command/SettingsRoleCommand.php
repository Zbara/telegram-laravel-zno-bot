<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Models\TelegramVideos;
use App\Telegram\Callback;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class SettingsRoleCommand extends Command
{
    protected $name = 'settings-role';

    private array $roles = [
        1 => 'ученика',
        2 => 'учителя',
    ];

    public function handle()
    {
        if (in_array(Callback::getParams(1), [1,2])) {
            RemoveMessages::remove();

            if(User::setNewUserRole(Callback::getParams(1))){
                $text = sprintf('Вы подали заявку на смену роли, выбрали %s. После модерации будет ответ.', $this->roles[Callback::getParams(1)]);
            } else $text ='Похоже что Вы, подали повторную заявку на смену роли, старая еще на рассмотрение.';

           return $this->replyWithMessage([
                'text' => $text,
                'chat_id' => $this->getUpdate()->getChat()->id,
                'reply_markup' => Keyboard::make([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Назад к настройкам', 'callback_data' => 'settings'],
                        ],
                    ],
                    'resize_keyboard' => true,
                ])
            ]);
        }
        return $this->replyWithMessage([
            'text' => 'Ошибка.',
        ]);
    }
}
