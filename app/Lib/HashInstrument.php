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
     * @param array $wordsIds
     * @return array
     */
    public static function hashAll(array $algorithms, array $wordsIds) : array
    {
        $hashFunctions = hash_algos();
        $newHashes = [];

        $words = Vocabulary::whereIn('id', $wordsIds)->get()->keyBy('id');

        foreach ($algorithms as $algorithm) {
            if (array_search($algorithm, $hashFunctions) === false) {
                continue;
            }
            //Selecting ready hashes
            $issetHashes = HashedWord::whereIn('word_id', $wordsIds)
                ->where('algorithm', $algorithm)->ofCurrentUser()->get();
            foreach ($issetHashes as $issetHash) {
                $newHashes[$words[$issetHash->word_id]->word][$algorithm] = $issetHash;
            }
            //Creating new hashes
            foreach ($words as $word) {
                if (!isset($newHashes[$word->word][$algorithm])) {
                    $newHashes[$word->word][$algorithm] = static::hashOne($algorithm, $word);
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
        //Creating new hash
        $hashedWord = hash($algorithm, $wordFromDb->word);
        $newHash = new HashedWord([
            'word_id' => $wordFromDb->id,
            'hash' => $hashedWord,
            'algorithm' => $algorithm,
        ]);
        $newHash->save();

        return $newHash;
    }
}