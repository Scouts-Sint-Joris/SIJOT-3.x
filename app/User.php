<?php

namespace Sijot;

use Cog\Ban\Traits\HasBans;
use Cog\Ban\Contracts\HasBans as HasBansContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;

/**
 * Eloquent User model.
 *
 * @category SIJOT-website
 * @package  App
 * @author   Tim Joosten <Topairy@gmail.com>
 * @license  MIT License
 * @link     http://www.st-joris-turnhout.be
 */
class User extends Authenticatable implements HasBansContract
{
    use HasRoles, Notifiable, HasBans;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['theme', 'avatar', 'name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Indicate the online status for the user.
     *
     * @return mixed
     */
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
}
