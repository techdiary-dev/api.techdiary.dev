<?php

namespace App\TechDiary\Reaction\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\TechDiary\Reaction\Model\Reaction
 *
 * @property string $id
 * @property string $ReactionAble_type
 * @property string $ReactionAble_id
 * @property string $type
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $reactBy
 * @property-read Model|\Eloquent $reactable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereReactionAbleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereReactionAbleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Reaction extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'user_id'];

    protected $casts = [
        'id' => 'string',
    ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    /**
     * Reactable model relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function reactable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user that reacted on reactable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reactBy()
    {
        $userModel = config('auth.providers.users.model');

        return $this->belongsTo($userModel, 'user_id');
    }
}
