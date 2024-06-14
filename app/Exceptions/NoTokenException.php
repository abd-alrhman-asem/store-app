<?php
// app/Exceptions/NoTokenException.php

namespace App\Exceptions;

use Exception;

class NoTokenException extends Exception
{
    protected $message;
    protected int $statusCode;

    /**
     * Constructor.
     *
     * @param string $message
     * @param int $statusCode
     */
    public function __construct(
        string $message = 'No token found for the user',
        int $statusCode = 401
    )
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    /**
     * Get the status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
