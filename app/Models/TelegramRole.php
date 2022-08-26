<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TelegramRole
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $role
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TelegramUsers[] $user
 * @property-read int|null $user_count
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramRole whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramRole whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramRole whereUserId($value)
 * @mixin \Eloquent
 */
class TelegramRole extends Model
{
    use HasFactory;

    public function user(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TelegramUsers::class, 'id', 'user_id');
    }
}
