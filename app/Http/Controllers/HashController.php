<?php
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 12:34
 */
namespace App\Http\Controllers;

use App\Models\HashedWord;
use Illuminate\Http\Request;
use App\Lib\HashInstrument;

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
        $words = $request->input('words');
        $algorithms = $request->input('algorithms');
        $newHashes = HashInstrument::hashAll($algorithms, $words);

        return [
            'words' => $newHashes
        ];
    }
}