<?php

namespace App\Telegram;

use App\Models\TelegramNewRole;
use App\Models\TelegramRole;
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

            $user = TelegramUsers::where('platform_id', $userData->id)->limit(1)->get();

            if (null === $user) {
                $user = TelegramUsers::create([
                    'platform_id' => $userData->id,
                    'login' => $userData->username ?? 'login_' . $userData->id,
                    'first_name' => $userData->firstName ?? 'firstName_' . $userData->id,
                    'last_name' =>   $userData->lastName ?? 'lastName_' . $userData->id,
                    'last_date' => Carbon::now(),
                    'command' => 'start',
                    'role' => 0,
                    'status' => 1,
                ]);
            }
            TelegramUsers::where('id', $user->value('id'))->update(
                [
                    'login' => $userData->username ?? 'login_' . $userData->id,
                    'first_name' => $userData->firstName ?? 'firstName_' . $userData->id,
                    'last_name' =>   $userData->lastName ?? 'lastName_' . $userData->id,
                    'last_date' => Carbon::now(),
                ]
            );

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

    public static function setVideo(int|null $video_id): void
    {
        self::$user->video_id = $video_id;
        self::$user->save();
    }

    public static function setVideoUploads(int|null $video_id): void
    {
        self::$user->upload_video = $video_id;
        self::$user->save();
    }

    public static function setNewUserRole(int $role): bool
    {
        if(TelegramRole::where('user_id', self::$user->id)->where('status', 0)->get()->isEmpty()) {
            $newRole = new TelegramRole();
            $newRole->role = $role;
            $newRole->status = 0;
            $newRole->user_id = self::$user->id;
            $newRole->save();

            return true;
        }
        return false;
    }
}
