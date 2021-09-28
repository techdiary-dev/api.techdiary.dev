<?php

namespace App\TechDiary;

use App\TechDiary\Reaction\Contracts\ReactorUserInterface;

trait VotableModel
{
    /**
     * Create vote to a del
     * @param $vote_type
     * @return mixed
     */
    public function vote($vote_type, ReactorUserInterface $user)
    {

        if ($this->isReactBy($user)) {

            $isAlreadyUpvotted = $this->isReactBy($user, 'UP_VOTE');
            $isAlreadyDownvotted = $this->isReactBy($user, 'DOWN_VOTE');

            if ($isAlreadyUpvotted && $vote_type == 'UP_VOTE') {
                $this->removeReaction('UP_VOTE', $user);
            }

            else if ($isAlreadyDownvotted && $vote_type == 'DOWN_VOTE') {
                $this->removeReaction('DOWN_VOTE', $user);
            }

            else if($isAlreadyDownvotted && $vote_type == 'UP_VOTE')
            {
                $this->removeReaction('DOWN_VOTE', $user);
                $this->storeReaction('UP_VOTE', $user);
            }
            else if($isAlreadyUpvotted && $vote_type == 'DOWN_VOTE')
            {
                $this->removeReaction('UP_VOTE', $user);
                $this->storeReaction('DOWN_VOTE', $user);
            }
        } else {
            $this->storeReaction($vote_type, $user);
        }

    }
}
