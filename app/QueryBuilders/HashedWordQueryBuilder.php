<?php
/**
 * Created by PhpStorm.
 * User: svinchak.v
 * Date: 15.09.2016
 * Time: 10:43
 */
namespace App\QueryBuilders;


use App\Product;
use App\Lib\UserDetector;
use Illuminate\Database\Query\Builder;

class HashedWordQueryBuilder extends Builder
{

    public function ofCurrentUser(int $wordId = 0)
    {
        if ($wordId > 0) {
            $this->where('word_id', $wordId);
        }
        $userId = UserDetector::detect();
        return $this->where('user_id', $userId);
    }

}