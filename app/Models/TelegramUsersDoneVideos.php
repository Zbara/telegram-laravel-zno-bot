<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TelegramUsersDoneVideos
 *
 * @property int $id
 * @property int $user_id
 * @property int $video_id
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsersDoneVideos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsersDoneVideos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsersDoneVideos query()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsersDoneVideos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsersDoneVideos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsersDoneVideos whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsersDoneVideos whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsersDoneVideos whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramUsersDoneVideos whereVideoId($value)
 * @mixin \Eloquent
 */
class TelegramUsersDoneVideos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'video_id',
    ];



}
