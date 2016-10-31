<?php
declare(strict_types = 1);
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed id
 */
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

    protected $casts = [
        'id' => 'integer',
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hashes()
    {
        return $this->hasMany(HashedWord::class, 'user_id', 'id');
    }
}
