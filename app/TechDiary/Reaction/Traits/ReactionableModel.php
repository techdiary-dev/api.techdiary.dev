<?php


namespace App\TechDiary\Reaction\Traits;

use App\Models\User;
use App\TechDiary\Reaction\Contracts\ReactorUserInterface;
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
     * Store reaction for model
     * @param $type
     * @param ReactorUserInterface $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function storeReaction($type, ReactorUserInterface $user)
    {
        return $this->reactions()->create([
            'type' => $type,
            'user_id' => $user->getKey()
        ]);
    }

    public function toggleReaction($type, ReactorUserInterface $user)
    {
        $reaction = $this->reactions()->where([
            'user_id' => $user->getKey(),
            'type' => $type
        ])->first();

        if (!$reaction) {
            $this->storeReaction($type, $user);
            return true;
        }else{
            $this->removeReaction($type, $user);
            return false;
        }
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
    public function isReactBy(ReactorUserInterface $user, $type = null)
    {
        $reacted = $this->reactions()->where([
            'user_id' => $user->getKey(),
        ]);

        if ($type) {
            $reacted->where([
                'type' => $type,
            ]);
        }

        return $reacted->exists();
    }

    /**
     * Remove reaction
     * @param $reactionType
     * @param null $user
     * @return bool
     */
    public function removeReaction($reactionType, $user = null)
    {
        $reaction = $this->reactions()->where([
            "user_id" => $user->getKey(),
            "type" => $reactionType
        ])->first();

        if ($reaction) {
            $reaction->delete();
            return true;
        }

        return false;

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

