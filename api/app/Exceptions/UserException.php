<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class UserException extends Exception
{
    public function __construct(string $message = 'Internal error')
    {
        parent::__construct($message);
    }
}
