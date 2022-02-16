<?php

namespace App\Exceptions;

use Exception;

class AuthorizationErrorException extends Exception
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
            'errors'=> [
                'code' => 403,
                'title' => 'Forbidden',
                'detail' => 'This action is unauthorized',
            ]
        ], 403);
    }
}
