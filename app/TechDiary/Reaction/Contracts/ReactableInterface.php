<?php


namespace App\TechDiary\Reaction\Contracts;


interface ReactableInterface
{
    /**
     * Collection of reactions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function reactions();
}
