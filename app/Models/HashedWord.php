<?php
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 23.10.2016
 * Time: 10:40
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\QueryBuilders\HashedWordQueryBuilder as QueryBuilder;

class HashedWord extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'word_id', 'user_id', 'hash', 'algorithm'
    ];

    protected $casts = [
        'word_id' => 'int',
        'user_id' => 'int',
    ];

    public $timestamps = false;

    public function word()
    {
        return $this->hasOne(Vocabulary::class, 'id', 'word_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

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
