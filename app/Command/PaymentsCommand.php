<?php

namespace App\Command;

use App\Command\Messages\TextList;
use App\Telegram\RemoveMessages;
use App\Telegram\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class PaymentsCommand extends Command
{
    protected $name = 'pay';

    public function handle()
    {
        /** удаление старого сообщения */
        RemoveMessages::remove();

        if(isset(User::getUser()->payments)){
            $text = 'Ваши платежные данные:';
            $text .= "\n\n" . User::getUser()->payments;
            $text .= "\n\nМожете ввести ниже новые.";
        } else $text = 'Укажите реквизиты для оплаты, введите их ниже.';

        $this->replyWithMessage([
            'text' => $text,
            'chat_id' => $this->getUpdate()->getChat()->id,
            'reply_markup' => Keyboard::make([
                'inline_keyboard' => [
                    [
                        ['text' => 'Назад', 'callback_data' => 'settings'],
                    ],
                ],
                'resize_keyboard' => true,
            ])
        ]);
    }
}
