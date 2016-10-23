<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip', 'browser', 'cookie', 'country'
    ];

    public $timestamps = false;

    public function hashes()
    {
        return $this->hasMany(HashedWord::class, 'user_id', 'id');
    }
}
