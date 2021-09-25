<?php


namespace App\TechDiary\Reaction\Traits;

use App\TechDiary\Reaction\Model\Reaction;
use App\TechDiary\Reaction\Resources\ReactionCollection;

trait ReactionableModel
{
    /**
     * Collection of reactions.
     * ------------------------------------------
     * Reactions relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'ReactionAble');
    }

    /**
     * Get collection of users who reacted on reactable model.
     *
     * @return \Illuminate\Support\Collection
     */
    public function reactionsBy()
    {
        $userModel = $this->resolveUserModel();
        return $userModel::whereKey($this->reactorIds())->get();
    }

    /**
     * Reactors user ids
     */
    public function reactorIds()
    {
        return $this->reactions->pluck('user_id');
    }


    /**
     * Reaction summary.
     *
     * @return ReactionCollection|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function reactionSummary()
    {
        $reactions = $this->reactions()->get();
        if ($reactions->isNotEmpty()) {
            return new ReactionCollection($reactions);
        }
    }

    /**
     * Check is reacted by user.
     *
     * @param mixed $user
     * @return bool
     */
    public function isReactBy($user = null, $type = null)
    {
        $user = $this->getUser($user);

        if ($user) {
            return $user->isReactedOn($this, $type);
        }

        return false;
    }

    /**
     * Add reaction.
     *
     * @param mixed $reactionType
     * @param mixed $user
     * @return Reaction|bool
     */
    public function react($reactionType, $user = null)
    {
        $user = $this->getUser($user);

        if ($user) {
            return $user->reactTo($this, $reactionType);
        }

        return false;
    }

    /**
     * Get Reaction
     * @param $reactionType
     * @param null $user
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\MorphMany|object|null
     */
    public function getReaction($user = null)
    {
        if ($user == null) $user = auth()->user();

        return $this->reactions()->where([
            'user_id' => $user->getKey()
        ])->first();
    }

    /**
     * Remove reaction
     * @param $reactionType
     * @param null $user
     * @return false
     */
    public function removeReaction($reactionType, $user = null)
    {
        $reaction = $this->reactions()->where([
            "user_id" => $user->getKey(),
            "type" => $reactionType
        ])->first();

        if($reaction)
        {
            $reaction->delete();
            return true;
        }

        return false;

    }

    /**
     * Get user model.
     *
     * @param mixed $user
     * @return false
     *
     * @throw \Qirolab\Laravel\Reactions\Exceptions\InvalidReactionUser
     */
    private function getUser($user = null)
    {
        return auth()->guard('sanctum')?->user();
    }


    /**
     * Retrieve User's model class name.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    private function resolveUserModel()
    {
        return config('auth.providers.users.model');
    }
}

