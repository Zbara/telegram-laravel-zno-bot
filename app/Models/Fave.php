<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Fave
 *
 * @property int $id
 * @property int $user_id
 * @property int $video_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Fave newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fave newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fave query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fave whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fave whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fave whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fave whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fave whereVideoId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TelegramVideos[] $videos
 * @property-read int|null $videos_count
 */
class Fave extends Model
{
    use HasFactory;

    public function videos(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TelegramVideos::class, 'id', 'video_id');
    }
}
