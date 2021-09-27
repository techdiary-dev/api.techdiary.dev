<?php


namespace App\TechDiary\Reaction\Traits;


use App\TechDiary\Reaction\Contracts\ReactableInterface;
use App\TechDiary\Reaction\Model\Reaction;

trait ReactorUserModel
{
//    /**
//     * Reaction on reactable model.
//     *
//     * @param ReactableInterface $reactable
//     * @param mixed $type
//     *
//     * @return bool|\Qirolab\Laravel\Reactions\Models\Reaction
//     */
//    public function reactTo(ReactableInterface $reactableModel, $type)
//    {
//        $likeCreated = false;
//        $reaction = $reactableModel->reactions()->where([
//            'user_id' => $this->getKey(),
//            'type' => $type
//        ])->first();
//
//        if (!$reaction) {
//            $this->storeReaction($reactableModel, $type);
//            $likeCreated = true;
//        } else {
//            $this->deleteReaction($reaction, $reactableModel);
//        }
//
//        return $likeCreated;
//    }
//
//    /**
//     * Remove reaction from reactable model.
//     *
//     * @param ReactableInterface $reactable
//     *
//     * @return void
//     */
//    public function removeReactionFrom(ReactableInterface $reactableModel)
//    {
//        $reaction = $reactableModel->reactions()->where([
//            'user_id' => $this->getKey(),
//        ])->first();
//
//        if (!$reaction) {
//            return;
//        }
//
//        $this->deleteReaction($reaction, $reactableModel);
//    }
//
//    /**
//     * Toggle reaction on reactable model.
//     *
//     * @param ReactableInterface $reactable
//     * @param mixed $type
//     *
//     * @return void
//     */
//    public function toggleReactionOn(ReactableInterface $reactableModel, $type)
//    {
//        $reaction = $reactableModel->reactions()->where([
//            'user_id' => $this->getKey(),
//        ])->first();
//
//        if (!$reaction) {
//            return $this->storeReaction($reactableModel, $type);
//        }
//
//        $this->deleteReaction($reaction, $reactableModel);
//
//        if ($reaction->type == $type) {
//            return;
//        }
//
//        return $this->storeReaction($reactableModel, $type);
//    }
//
//    /**
//     * Reaction on reactable model.
//     *
//     * @param ReactableInterface $reactableModel
//     *
//     * @return Reaction
//     */
//    public function ReactedOn(ReactableInterface $reactableModel)
//    {
//        return $reactableModel->reacted($this);
//    }
//
//    /**
//     * Check is reacted on reactable model.
//     *
//     * @param ReactableInterface $reactable
//     * @param mixed $type
//     *
//     * @return bool
//     */
//    public function isReactedOn(ReactableInterface $reactableModel, $type = null)
//    {
//        $isReacted = $reactableModel->reactions()->where([
//            'user_id' => $this->getKey(),
//        ]);
//
//        if ($type) {
//            $isReacted->where([
//                'type' => $type,
//            ]);
//        }
//
//        return $isReacted->exists();
//    }
//
//    /**
//     * Store reaction.
//     *
//     * @param ReactableInterface $reactableModel
//     * @param mixed $type
//     * @return \Qirolab\Laravel\Reactions\Models\Reaction
//     */
//    protected function storeReaction(ReactableInterface $reactableModel, $type)
//    {
//        $reaction = $reactableModel->reactions()->create([
//            'user_id' => $this->getKey(),
//            'type' => $type,
//        ]);
//
//        // Todo: Add an event here
//
//        return $reaction;
//    }
//
//    /**
//     * Delete reaction.
//     *
//     * @param Reaction $reaction
//     * @return void
//     * @throws \Exception
//     */
//    protected function deleteReaction(Reaction $reaction)
//    {
//        $response = $reaction->delete();
//        // Todo: Add an event here
//        return $response;
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function reactions()
//    {
//        return $this->hasMany(Reaction::class);
//    }

}
