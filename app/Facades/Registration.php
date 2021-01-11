<?php


namespace App\Facades;


use App\Services\Authentication\RegistrationService;
use Illuminate\Support\Facades\Facade;

class Registration extends Facade
{
    protected static function getFacadeAccessor()
    {
        return RegistrationService::class;
    }
}
