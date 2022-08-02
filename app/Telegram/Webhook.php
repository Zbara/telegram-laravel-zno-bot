<?php

namespace App\Telegram;

use App\Models\TelegramUsersDoneVideos;
use Telegram\Bot\Api;

class Webhook
{
    private Api $bot;

    public function __construct(
        Api $bot,
        RemoveMessages $messages
    )
    {
        $this->bot = $bot;
    }

    /**
     * Получение данных от телеграм, точка входа
     * @return mixed|string|\Telegram\Bot\Objects\Message
     */
    public function kernel(): mixed
    {
        $userData = $this->bot->getWebhookUpdate()->getChat();

        try {
            $user = User::telegramUser($userData);

            /** Если команда запущенная через / */
            if ($this->bot->getWebhookUpdate()->hasCommand()) {
                User::updateUser($user);

                $this->bot->commandsHandler(true);

                return 'command accepted';
            }

            /** @var  $callback */
            if ($callback = $this->bot->getWebhookUpdate()->get('callback_query')) {
                if (Callback::setParams($callback->get('data'))) {

                    /** не пишем команду удаление в БД */
                    if (Callback::getParams() != 'remove-videos') {
                        User::updateUser($user, Callback::getParams());
                    }
                    return $this->bot->triggerCommand(Callback::getParams(), $this->bot->commandsHandler(true));
                }
            }

            /** видео */
            if ($user->command == 'teacher-videos') {
                return $this->bot->triggerCommand('teacher-videos-uploads', $this->bot->commandsHandler(true));
            }

            /** ответы пользователя */
            if ($user->command == 'student-videos' and User::getUser()->video_id > 0) {
                return $this->bot->triggerCommand('student-videos-answer', $this->bot->commandsHandler(true));
            }

            return $this->bot->sendMessage([
                'chat_id' => $this->bot->getWebhookUpdate()->getChat()->id,
                'text' => 'Команда не найдена.'
            ]);

        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
        }
        return 'User not found.';
    }
}
