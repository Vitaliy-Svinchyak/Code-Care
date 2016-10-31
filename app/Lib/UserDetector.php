<?php
declare(strict_types=1);
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

/**
 * Class UserDetector
 * @package App\Lib
 */
class UserDetector
{
    protected static $user;

    /**
     * Returns an id of current user
     * @return int
     */
    public static function detect() : int
    {
        $user = static::findUser();
        return $user->id;
    }

    /**
     * Detects user
     * @return User
     */
    protected static function findUser() : User
    {
        if(!static::$user) {
            $ip = Request::ip();
            $browser = Request::header('User-Agent');
            $cookie = json_encode(Cookie::get());
            $country = Geo::getUsersCountry();
            $user = User::firstOrNew([
                'ip' => $ip,
                'browser' => $browser,
                'country' => $country
            ]);
            if ($user->cookie !== $cookie) {
                $user->cookie = $cookie;
            }
            $user->save();
            static::$user = $user;
        }

        return static::$user;
    }
}