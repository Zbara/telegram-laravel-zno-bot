<?php

namespace App\Telegram;

use App\Models\TelegramUsers;
use Carbon\Carbon;
use Telegram\Bot\Objects\Chat;

class User
{
    private static ?TelegramUsers $user;

    public static function getUser(): TelegramUsers
    {
        return self::$user;
    }

    public static function setUser(TelegramUsers $user): void
    {
        self::$user = $user;
    }

    /**
     * @param Chat $userData
     * @return TelegramUsers
     */
    public static function telegramUser(Chat $userData): TelegramUsers
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
                    'role' => 0,
                ]);
            }
            User::setUser($user);

            return $user;
        }
        return new TelegramUsers();
    }

    /**
     * @param TelegramUsers $user
     * @param string $command
     * @param bool $reset
     * @return void
     */
    public static function updateUser(TelegramUsers $user, string $command = 'start', bool $reset = false): void
    {
        $user->last_date = Carbon::now();
        $user->command = $command;
        if ($reset) {
            $user->subject = null;
            $user->upload_video = null;
        }
        $user->save();
    }

    public static function setRole(int $role = 0): void
    {
        self::$user->role = $role;
        self::$user->save();
    }


    public static function setStartCommand(string $command): void
    {
        self::$user->command = $command;
        self::$user->save();
    }

    public static function setVideo(int $video_id): void
    {
        self::$user->video_id = $video_id;
        self::$user->save();
    }
}
