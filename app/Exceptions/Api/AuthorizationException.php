<?php


namespace App\Exceptions\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AuthorizationException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request)
    {
        if ($request->route('api/*') or !App::environment('local')) {
            $error = ['error' => true, 'message' => $this->getMessage()];

            return response($error);
        }
    }
}
