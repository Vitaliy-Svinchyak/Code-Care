<?php
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 13:50
 */

namespace App\Lib;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Cookie;
use App\Lib\Geo;

class UserDetector
{
    public static function detect()
    {
        $user = static::findUser();
        return $user->id;
    }

    protected static function findUser() : User
    {
        $ip = Request::ip();
        $browser = Request::header('User-Agent');
        $cookie = json_encode(Cookie::get());
        $country = Geo::getUsersCountry();
        $user = User::firstOrNew([
            'ip' => $ip,
            'browser' => $browser,
            'country' => $country
        ]);
        if ($user->cookie != $cookie) {
            $user->cookie = $cookie;
        }
        $user->save();
        return $user;
    }
}