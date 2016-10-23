<?php
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 22:38
 */

namespace App\Lib;

use App\Models\Vocabulary;

class WordSaver
{
    /**
     * Saves 1 word
     * @param string $word
     * @return Vocabulary
     */
    public static function saveOne(string $word) : Vocabulary
    {
        $issetWord = Vocabulary::where('word', $word)->first();
        if ($issetWord) {
            return $issetWord;
        }
        $newWord = new Vocabulary(['word' => $word]);
        $newWord->save();
        return $newWord;
    }
}