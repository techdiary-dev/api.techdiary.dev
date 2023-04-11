<?php

namespace App\TechDiary\Reaction\Exceptions;

class InvalidReactionUser extends \Exception
{
    /**
     * Reaction user not defined.
     *
     * @return static
     */
    public static function notDefined()
    {
        return new static('Reaction user not defined.');
    }

    /**
     * Invalid reaction user.
     *
     * @return static
     */
    public static function invalidReactByUser()
    {
        return new static('Invalid Reaction user.');
    }
}
