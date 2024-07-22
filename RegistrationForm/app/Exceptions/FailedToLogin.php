<?php

namespace App\Exceptions;

use Exception;

class FailedToLogin extends Exception
{
    public function __construct($message = "Custom exception occurred", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function report()
    {
        // Logic to report the exception (e.g., send to an external monitoring service)
    }

    public function render()
    {
        // Custom response to be sent to the client
        return response()->json([
            'error' => 'Email or Password is incorrect',
            'message' => $this->getMessage(),
        ]);
    }
}
