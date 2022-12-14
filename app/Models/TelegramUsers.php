<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property int|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TelegramVideos[] $videos
 * @property-read int|null $videos_count
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereRole($value)
 * @property int|null $upload_video
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereUploadVideo($value)
 * @property int|null $video_id
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereVideoId($value)
 * @property string|null $payments
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers wherePayments($value)
 * @property int $status
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsers whereStatus($value)
 */
class TelegramUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform_id',
        'login',
        'first_name',
        'last_name',
        'last_date',
        'command',
    ];

    public function videos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TelegramVideos::class, 'user_id');
    }
}
