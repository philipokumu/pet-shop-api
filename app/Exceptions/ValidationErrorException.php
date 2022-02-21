<?php

namespace App\Exceptions;

use Exception;

class ValidationErrorException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'success' => 0,
            'data' => [],
            'error' => json_decode($this->getMessage()),
            'errors' => [
                'title' => 'Validation error',
                'meta' => json_decode($this->getMessage())
            ],
                'trace' => []
        ], 422);
    }
}
