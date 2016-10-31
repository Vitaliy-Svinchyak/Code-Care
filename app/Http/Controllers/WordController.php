<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 12:34
 */
namespace App\Http\Controllers;

use App\Lib\WordSaver;
use App\Models\Vocabulary;
use Illuminate\Http\Request;

/**
 * Class WordController
 * @package App\Http\Controllers
 */
class WordController extends Controller
{

    /**
     * Finds words from db by name
     * @param Request $request
     * @return array
     */
    public function find(Request $request)
    {
        $word = $request->input('word');
        $issetWords = Vocabulary::ofCurrentUser()->where('word', 'LIKE', "%{$word}%")->take(25)->get();
        return ['words' => $issetWords];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $word = $request->input('word');
        $newWord = WordSaver::saveOne($word);

        return ['word' => $newWord];
    }
}