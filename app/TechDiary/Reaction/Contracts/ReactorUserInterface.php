<?php


namespace App\TechDiary\Reaction\Contracts;


use App\TechDiary\Reaction\Traits\ReactionableModel;

interface ReactorUserInterface
{
    /**
     * Reaction on reactable model.
     *
     * @param  ReactableInterface $reactable
     * @param  mixed              $type
     * @return void
     */
//    public function reactTo(ReactionableModel $reactable, $type);
    public function reactions();
}
