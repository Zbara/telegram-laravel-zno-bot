<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\TelegramUsers
 *
 * @property int $id
 * @property int $platform_id
 * @property string $login
 * @property string $first_name
 * @property string $last_name
 * @property string $command
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property string|null $last_date
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers query()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereCommand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereLastDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers wherePlatformId($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $subject
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereUpdatedAt($value)
 */
	class TelegramUsers extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TelegramVidoes
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVidoes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVidoes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVidoes query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property string|null $file_name
 * @property int|null $file_size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVideos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVideos whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVideos whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVideos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVideos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVideos whereUserId($value)
 * @property int|null $subject
 * @property string|null $tags
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVideos whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVideos whereTags($value)
 */
	class TelegramVideos extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TelegramUsers[] $videos
 * @property-read int|null $videos_count
 */
	class User extends \Eloquent {}
}

