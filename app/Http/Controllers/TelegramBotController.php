<?php

namespace App\Http\Controllers;

use App\Models\TelegramUsers;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Chat;

class TelegramBotController extends Controller
{
    private Api $bot;

    public function __construct(
        Api $bot,
    )
    {
        $this->bot = $bot;
    }

    private function getUser(Chat $userData): TelegramUsers
    {
        if ($userData->get('id') !== null) {

            $user = TelegramUsers::where('platform_id', $userData->id)->first();

            if (null === $user) {
                $user = TelegramUsers::create([
                    'platform_id' => $userData->id,
                    'login' => $userData->username ?? 'user_' . $userData->id,
                    'first_name' => $userData->firstName ?? 'user_' . $userData->id,
                    'last_name' => $userData->lastName ?? '',
                    'last_date' => Carbon::now(),
                    'command' => 'start',
                ]);
            }
            return $user;
        }
        return new TelegramUsers();
    }

    private function updateUser(TelegramUsers $user, string $command = 'start', bool $reset = false)
    {
        $user->last_date = Carbon::now();
        $user->command = $command;
        if ($reset) {
            $user->subject = null;
        }
        $user->save();
    }

    public function webHook()
    {
        $userData = $this->bot->getWebhookUpdate()->getChat();

        try {
            $user = $this->getUser($userData);

            /** Если команда запущенная через / */
            if ($this->bot->getWebhookUpdate()->hasCommand()) {

                $this->updateUser($user, 'start');

                $this->bot->commandsHandler(true);

                return 'command accepted';
            }

            $commandMessage = $this->bot->getWebhookUpdate()->getMessage()->text;
            $commandByText = null;


            if (in_array($commandMessage, ['Назад к урокам', 'Назад к предмету'])) {
                $home = [
                    'teacher-items' => 'teacher',
                    'teacher-videos' => 'teacher-items',
                    'teacher-videos-users' => 'teacher-items',
                ];
                $command = $user->command;

                if (isset($home[$command])) {
                    $this->updateUser($user, $home[$command], true);

                    return $this->bot->triggerCommand($home[$command], $this->bot->commandsHandler(true));
                }
            }

            foreach ($this->bot->getCommands() as $command) {
                $this->bot->commandsHandler(true);

                if (in_array($commandMessage, $command->getAliases())) {
                    $commandByText = $command->getName();
                }
            }

            Log::info('command text ' . $commandByText);

            /** Команда по тексту */
            if (isset($commandByText)) {
                $this->updateUser($user, $commandByText);

                return $this->bot->triggerCommand($commandByText, $this->bot->commandsHandler(true));
            }

            return $this->bot->sendMessage([
                'chat_id' => $this->bot->getWebhookUpdate()->getChat()->id,
                'text' => 'Команда не найдена.'
            ]);

        } catch (\Throwable $e) {

        }
        return 'User not found.';
    }
}
