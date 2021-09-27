<?php

namespace App\TechDiary;

trait Votable
{
    /**
     * Create vote to a del
     * @param $vote_type
     * @return mixed
     */
    public function vote($vote_type)
    {
        $types = [
            "UP_VOTE",
            "DOWN_VOTE"
        ];

        $requested_vote = $vote_type == 'UP_VOTE' ? 0 : 1;

        if (auth()->user()->isReactedOn($this)) // vote exists
        {
            $current_vote = $this->getReaction()->type == 'UP_VOTE' ? 0 : 1;

            if($current_vote == $requested_vote)
            {
                $this->removeReaction($vote_type, auth()->user());
            }
            else{
                $this->removeReaction($types[$current_vote], auth()->user());
                $this->react($types[!$current_vote], auth()->user());
            }
        } else { // no vote
            $this->react($vote_type, auth()->user());
        }

        return $this->reactionSummary();
    }


    public function voteSummery()
    {

    }
}
