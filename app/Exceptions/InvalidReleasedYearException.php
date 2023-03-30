<?php

namespace App\Exceptions;

use Exception;

class InvalidReleasedYearException extends Exception
{
    public function message()
    {
        return 'La valeur du "year_release" doit inférieure à '. date('Y')+1;
    }
}
