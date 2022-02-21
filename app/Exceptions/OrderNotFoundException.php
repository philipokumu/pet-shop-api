<?php

namespace App\Exceptions;

use Exception;

class OrderNotFoundException extends Exception
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
            'error' => 'Failed to create new order',
            'errors' => [],
                'trace' => []
        ], 422);
    }
}
