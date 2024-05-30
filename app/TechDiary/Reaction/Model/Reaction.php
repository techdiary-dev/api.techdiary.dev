<?php

namespace App\TechDiary\Reaction\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


class Reaction extends Model
{
    use HasUuids;

    protected $fillable = ['type', 'user_id'];

    protected $casts = [
        'id' => 'string',
    ];


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
