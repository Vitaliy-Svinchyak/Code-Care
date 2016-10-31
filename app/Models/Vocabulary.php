<?php
declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 10:40
 */
namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use App\QueryBuilders\VocabularyQueryBuilder as QueryBuilder;

/**
 * @property mixed word
 * @property mixed id
 */
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
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $conn = $this->getConnection();

        $grammar = $conn->getQueryGrammar();

        return new QueryBuilder($conn, $grammar, $conn->getPostProcessor());
    }

}
