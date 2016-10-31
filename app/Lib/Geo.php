<?php
declare(strict_types = 1);

namespace App\Lib;

use Ixudra\Curl\Facades\Curl;
use SoapBox\Formatter\Formatter;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

/**
 * Class Geo
 * @package App\Lib
 */
class Geo
{
    protected static $geoInfo = [];

    /**
     * Returns users country
     * @return string|bool
     */
    public static function getUsersCountry()
    {
        $geoInfo = static::getGeoInformation();
        $country = $geoInfo['ip']['country'] ?? false;

        return $country;
    }

    /**
     * Returns geo information about user
     * @return array
     */
    public static function getGeoInformation() : array
    {
        $geoInfo = Session::get('geoInfo');

        if (!$geoInfo) {
            $ip = Request::ip();
            if ($ip) {
                $data = Curl::to('http://ipgeobase.ru:7020/geo?ip=' . '37.57.105.72')->get();
                $geoInfo = Formatter::make($data, Formatter::XML)->toArray();
                Session::set('geoInfo', $geoInfo);
            }
        }
        return $geoInfo;
    }

}