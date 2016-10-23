<?php
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 12:34
 */
namespace App\Http\Controllers;

use App\Models\Vocabulary;
use App\Models\HashedWord;
use Illuminate\Http\Request;

class HashController extends Controller
{

    /**
     * Returns all hashed words of current user
     * @return array
     */
    public function index()
    {
        $groupedWords = [];
        $hashedWords = HashedWord::ofCurrentUser()->with('word')->get();
        foreach ($hashedWords as $hashedWord) {
            $groupedWords[$hashedWord->word->word][$hashedWord->algorithm] = $hashedWord->hash;
        }
        return ['words' => $groupedWords];
    }

    /**
     * Creates a hash of all given words with all given algorithms and returns them
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $newHashes = [];
        $words = $request->input('words');
        $hashes = $request->input('algorithms');
        foreach ($hashes as $algorithm) {
            foreach ($words as $word) {
                //Checking if we have such word
                $wordFromDb = Vocabulary::find($word);
                if ($wordFromDb) {
                    //If we have such hashed word - we don't need to encrypt it again(I think)
                    $issetHash = HashedWord::where([
                        'word_id' => $word,
                        'algorithm' => $algorithm,
                    ])->ofCurrentUser()->first();
                    if ($issetHash) {
                        $newHash = $issetHash;
                    } else {
                        //Creating new hash
                        $hashedWord = hash($algorithm, $wordFromDb->word);
                        $newHash = new HashedWord([
                            'word_id' => $word,
                            'hash' => $hashedWord,
                            'algorithm' => $algorithm,
                        ]);
                        $newHash->save();
                    }
                    $newHashes[$wordFromDb->word][$algorithm] = $newHash;
                }
            }
        }
        return [
            'words' => $newHashes
        ];
    }
}