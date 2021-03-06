<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 12:34
 */
namespace App\Http\Controllers;

use App\Models\HashedWord;
use App\Models\Vocabulary;
use App\Lib\HashInstrument;
use Illuminate\Http\Request;

/**
 * Class HashController
 * @package App\Http\Controllers
 */
class HashController extends Controller
{

    /**
     * Returns all hashed words of current user
     * @return array
     */
    public function index()
    {
        $words = Vocabulary::ofCurrentUser()->get();
        return ['words' => $words];
    }

    /**
     * @param int $wordId
     * @return array
     */
    public function show(int $wordId)
    {
        $response = [];
        $word = Vocabulary::find($wordId);
        $response[$word->word] = HashedWord::ofCurrentUser($wordId)->get();
        return ['words' => $response];
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