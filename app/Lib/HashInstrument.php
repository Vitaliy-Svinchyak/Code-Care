<?php
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 22:32
 */

namespace App\Lib;

use App\Models\Vocabulary;
use App\Models\HashedWord;

class HashInstrument
{

    /**
     * Hashes all words with all algorithms
     * @param array $algorithms
     * @param array $words
     * @return array
     */
    public static function hashAll(array $algorithms, array $words) : array
    {
        $newHashes = [];
        foreach ($algorithms as $algorithm) {
            foreach ($words as $word) {
                //Checking if we have such word
                $wordFromDb = Vocabulary::find($word);
                if ($wordFromDb) {
                    $newHashes[$wordFromDb->word][$algorithm] = static::hashOne($algorithm, $wordFromDb);
                }
            }
        }
        return $newHashes;
    }

    /**
     * Hashes  word with given algorithm
     * @param string $algorithm
     * @param Vocabulary $wordFromDb
     * @return HashedWord
     */
    public static function hashOne(string $algorithm, Vocabulary $wordFromDb) : HashedWord
    {
        //If we have such hashed word - we don't need to encrypt it again(I think)
        $issetHash = HashedWord::where([
            'word_id' => $wordFromDb->id,
            'algorithm' => $algorithm,
        ])->ofCurrentUser()->first();
        if ($issetHash) {
            $newHash = $issetHash;
        } else {
            //Creating new hash
            $hashedWord = hash($algorithm, $wordFromDb->word);
            $newHash = new HashedWord([
                'word_id' => $wordFromDb->id,
                'hash' => $hashedWord,
                'algorithm' => $algorithm,
            ]);
            $newHash->save();
        }
        return $newHash;
    }
}