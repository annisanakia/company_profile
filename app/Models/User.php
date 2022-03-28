<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\PasswordReset;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'ng_department_id', 'phone'
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

    protected $dates = ['deleted_at'];

    
    public static $rules = array(
        'username' => 'required|unique:users,username,NULL,id,deleted_at,NULL',
        'name' => 'required',
        'password' => 'required',
        'email' => 'email|nullable',
        'phone' => 'numeric|nullable'
    );

    public static $customMessages = array(
        'required' => 'This field required.',
        'username.unique' => 'Username has been taken.',
        'email' => 'Invalid Email Address.'
    );

    public function validate($data)
    {
        $v = Validator::make($data, user::$rules, user::$customMessages);
        return $v;
    }

    public function createUser($data, $groups = array(), $default = 0)
    {
        $data['password'] = \Hash::make($data['password']);
        $user = User::create($data);
        $i = 0;
        foreach ($groups as $g) {
            $gr = \Models\groups::where('code', $g)
                ->first();

            if ($gr) {
                $gid = $gr->id;
                $def = 0;
                if ($default == 0) {
                    if ($i == 0) {
                        $def = 1;
                    }
                } else {
                    if ($g == $default) {
                        $def = 1;
                    }
                }
                \Models\user_group::create([
                    'users_id' => $user->id,
                    'groups_id' => $gid,
                    'default' => $def
                ]);
                ++$i;
            }
        }

        return $user;
    }

    public function user_group()
    {
        return $this->hasMany('Models\user_group', 'users_id', 'id');
    }

    public function users_photo()
    {
        return $this->hasOne('Models\users_photo', 'users_id', 'id');
    }

    public function user_access()
    {
        return $this->hasMany('Models\user_access', 'users_id', 'id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token, $this));
    }
}