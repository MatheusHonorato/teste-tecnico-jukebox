<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class RepositoryExceptionNotFound extends Exception
{
    public function __construct(string $message = 'Repository not found')
    {
        parent::__construct($message);
    }
}
