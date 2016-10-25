<?php


namespace App\Lib;

use Ixudra\Curl\Facades\Curl;
use SoapBox\Formatter\Formatter;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Geo
{
    static $geoInfo = [];

    /**
     * Returns users country
     * @return string
     */
    public static function getUsersCountry() : string
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