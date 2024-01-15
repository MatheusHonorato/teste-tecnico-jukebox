<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class TaskExceptionNotFound extends Exception
{
    public function __construct(string $message = 'Not found')
    {
        parent::__construct($message);
    }
}
