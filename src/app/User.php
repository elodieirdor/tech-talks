<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User",
 *     type="object"
 * )
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * @OA\Property(
     *     title="name",
     *     property="name",
     *     description="Name of the user",
     *     type="string",
     * )
     */

    /**
     * @OA\Property(
     *     title="email",
     *     property="email",
     *     description="Email of the user",
     *     type="string",
     * )
     */

    /**
     * @OA\Property(
     *     title="id",
     *     property="id",
     *     description="ID of the user",
     *     type="number",
     * )
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $visible = [
        'id',
        'name',
        'email'
    ];

    public function talks()
    {
        return $this->hasMany(Talk::class);
    }
}
