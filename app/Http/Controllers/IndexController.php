<?php
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 10:30
 */

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Vocabulary;


class IndexController extends BaseController
{
    public function showIndex()
    {
        return view('index');
    }

    /**
     * Returns an array of hash algorithms and 25 user words
     * @return array
     */
    public function getInfo()
    {
        $hashFunctions = hash_algos();
        $words = Vocabulary::ofCurrentUser()->take(25)->get();
        return [
            'functions' => $hashFunctions,
            'words' => $words,
        ];
    }
}
