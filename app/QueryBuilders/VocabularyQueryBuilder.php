<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: svinchak.v
 * Date: 15.09.2016
 * Time: 10:43
 */
namespace App\QueryBuilders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use App\Models\HashedWord;

class VocabularyQueryBuilder extends Builder
{

    public function ofCurrentUser()
    {
        $wordIds = HashedWord::ofCurrentUser()
            ->select(DB::raw('DISTINCT word_id'))
            ->get()
            ->toArray();

        return $this->whereIn('id', $wordIds);
    }

}