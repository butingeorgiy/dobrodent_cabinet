<?php


namespace App\Exceptions\Api;


use Exception;
use Illuminate\Http\Request;

class UncategorizedApiException extends Exception
{
    public function render(Request $request)
    {
        if ($request->is('api/*')) {
            $error = ['error' => true, 'message' => $this->getMessage()];

            return response($error);
        }
    }
}
