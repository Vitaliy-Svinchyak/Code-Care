<?php
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 10:40
 */
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $table = 'vocabulary';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'word',
    ];

    public $timestamps = false;

    /**
     * Returns query for first 25 user words
     * @return QueryBuilder
     */
    public static function ofCurrentUser()
    {
        $wordIds = HashedWord::ofCurrentUser()
            ->select(DB::raw('DISTINCT word_id'))
            ->take(25)
            ->get()
            ->toArray();

        return static::whereIn('id', $wordIds);
    }

}
