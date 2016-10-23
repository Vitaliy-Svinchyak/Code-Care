<?php
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 12:34
 */
namespace App\Http\Controllers;

use App\Models\Vocabulary;
use Illuminate\Http\Request;

class WordController extends Controller
{

    /**
     * Finds words from db
     * @param Request $request
     * @return array
     */
    public function find(Request $request)
    {
        $word = $request->input('word');
        $issetWords = Vocabulary::where('word', 'LIKE', "%{$word}%")->take(25)->get();
        return ['words' => $issetWords];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $word = $request->input('word');
        $issetWord = Vocabulary::where('word', $word)->first();
        if ($issetWord) {
            return $issetWord;
        }
        $newWord = new Vocabulary(['word' => $word]);
        $newWord->save();

        return ['word' => $newWord];
    }
}