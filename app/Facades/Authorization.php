<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;
use App\Services\Authentication\AuthorizationService;

class Authorization extends Facade
{
    protected static function getFacadeAccessor() {
        return AuthorizationService::class;
    }
}
