<?php

namespace App\Models\AuthTokens;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

abstract class Token extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    public static function add($entity, $needToSave)
    {
        $class = get_called_class();

        $token = Str::random(32);

        $entity->tokens()->save(
            new $class([
                'token' => $token,
                'time_valid' => $needToSave ? 604800 : 28800
            ])
        );

        return [
            'id' => [encrypt($entity->id), $needToSave ? 10080 : 480],
            'token' => [encrypt(self::generateCookieToken($entity, $token)), $needToSave ? 10080 : 480],
            'entityName' => [encrypt(get_class($entity)), $needToSave ? 10080 : 480]
        ];
    }

    private static function generateCookieToken($entity, $token)
    {
        $password = Str::limit($entity->password, 10);
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        return hash('sha256', $password . $userAgent . $token);
    }

    public function removeInvalid() {

    }
}
