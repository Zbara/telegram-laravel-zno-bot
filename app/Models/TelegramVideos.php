<?php

namespace App\Models;

use App\Telegram\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property string|null $theme
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramVideos whereTheme($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TelegramUsersDoneVideos[] $doneList
 * @property-read int|null $done_list_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TelegramUsersDoneVideos[] $subscribers
 * @property-read int|null $subscribers_count
 */
class TelegramVideos extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_size',
        'file_name',
        'user_id',
        'tags',
        'subject',
    ];

    public function subscribers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TelegramUsersDoneVideos::class, 'video_id');
    }

    public static function getVideo(): \Illuminate\Database\Eloquent\Builder|TelegramVideos|\Illuminate\Database\Query\Builder|null
    {
        $done = TelegramUsersDoneVideos::where('user_id', User::getUser()->id)->pluck('video_id')->all();

        if (count($done) > 0) {
            $videos = TelegramVideos::where('subject', User::getUser()->subject)->whereNotIn('id', $done)->inRandomOrder()->first();
        } else  $videos = TelegramVideos::where('subject', User::getUser()->subject)->inRandomOrder()->first();

        if(isset($videos->id)) {
            User::setVideo($videos->id);

            return $videos;
        }
        return null;
    }
}
