<?php

namespace App\Telegram;

use App\Models\TelegramUsersDoneVideos;
use Telegram\Bot\Api;

class Webhook
{
    private Api $bot;

    public function __construct(
        Api $bot,

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

                User::updateUser($user, 'start');

                $this->bot->commandsHandler(true);

                return 'command accepted';
            }
            $commandMessage = $this->bot->getWebhookUpdate()->getMessage()->text;
            $commandByText = null;

            /** видео */
            if ($user->command == 'teacher-videos' and !in_array($commandMessage, ['Назад к урокам', 'Назад к предмету'])) {
                return $this->bot->triggerCommand('teacher-videos-uploads', $this->bot->commandsHandler(true));
            }

            if ($user->command == 'student-videos' and !in_array($commandMessage, ['Назад к урокам', 'Назад к предмету']) and User::getUser()->video_id > 0) {
                return $this->bot->triggerCommand('student-videos-answer', $this->bot->commandsHandler(true));
            }

            /** Удаление видео */
            if ($callback = $this->bot->getWebhookUpdate()->get('callback_query')) {
                $data = explode(',', $callback->get('data'));

                if (isset($data[0])) {
                    return $this->bot->triggerCommand($data[0], $this->bot->commandsHandler(true));
                }
            }

            if (in_array($commandMessage, ['Назад к урокам', 'Назад к предмету'])) {
                $home = [
                    'teacher-items' => 'teacher',
                    'teacher-videos' => 'teacher-items',
                    'teacher-videos-users' => 'teacher-items',
                    'teacher-my' => 'teacher',
                    'student-videos' => 'student',
                ];
                $command = $user->command;

                if (isset($home[$command])) {
                    User::updateUser($user, $home[$command], true);

                    return $this->bot->triggerCommand($home[$command], $this->bot->commandsHandler(true));
                }
            }

            foreach ($this->bot->getCommands() as $command) {
                $this->bot->commandsHandler(true);

                if (in_array($commandMessage, $command->getAliases())) {
                    $commandByText = $command->getName();
                }
            }

            /** Команда по тексту */
            if (isset($commandByText)) {
                if ($user->role == 1 and $user->command == 'student') {
                    $commandByText = 'student-videos';
                }

                User::updateUser($user, $commandByText);

                return $this->bot->triggerCommand($commandByText, $this->bot->commandsHandler(true));
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
