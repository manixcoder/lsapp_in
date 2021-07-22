<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, EntrustUserTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'profile_bio',
        'website_url',
        'is_active',
        'profile_photo',
        'is_newQuestionArrivedNotification',
        'is_reply_to_your_answer',
        'is_expert_response_to_question'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function getRole()
    {
        return $this->hasOne('App\Models\Role', 'id');
    }
    /**
     * Check Roles admin here 
     *
     * @var array
     */
    public function isAdmin()
    {
        $role = Role::join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->where('user_id', Auth::user()->id)
            ->first();
        return $role->name == 'admin' ? true : false;
    }

    /**
     * Check Roles customer here 
     *
     * @var array
     */
    public function isExpert()
    {

        $role = Role::join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->where('user_id', Auth::user()->id)
            ->first();

        return $role->name == 'expert' ? true : false;
    }


    /**
     * Return user role here.
     *
     * @var string
     */

    public static function userRole($uid)
    {
        $data = self::join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->where('user_id', $uid)
            ->first();

        return $data->name;
    }
}
