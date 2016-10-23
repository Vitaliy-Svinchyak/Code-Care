<?php
/**
 * Created by PhpStorm.
 * User: opiru
 * Date: 22.09.2016
 * Time: 14:31
 */
namespace App\Observers;

use App\Models\HashedWord;
use App\Lib\UserDetector;

class HashedWordObserver
{
    public function saving(HashedWord $hashedWord)
    {
        $userId = UserDetector::detect();
        $hashedWord->user_id = $userId;
        return true;
    }

}