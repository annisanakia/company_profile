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
        'name', 'username', 'email', 'password', 'ng_department_id', 'client_id', 'phone', 'is_register_client', 'ng_user_type_id'
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

    public static $rules = array(
        'username' => 'required',
        'name' => 'required'
    );
    protected $dates = ['deleted_at'];

    public function validate($data)
    {
        $v = Validator::make($data, user::$rules);
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

    public function is_has_groups($groups_ids)
    {
        $groups = $this->user_group()->get();
        if ($groups->count() > 0) {
            foreach ($groups as $group) {
                if (in_array($group->groups_id, $groups_ids)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function users_photo()
    {
        return $this->hasOne('Models\users_photo', 'users_id', 'id');
    }

    public function ng_test_applicant()
    {
        return $this->hasOne('Models\ng_test_applicant', 'users_id', 'id');
    }

    public function ng_student()
    {
        return $this->hasOne('Models\ng_student', 'users_id', 'id');
    }

    public function ng_department()
    {
        return $this->belongsTo('Models\ng_department');
    }

    public function ng_user_access()
    {
        return $this->hasMany('Models\ng_user_access', 'users_id', 'id');
    }

    public function ng_user_relation()
    {
        return $this->hasMany('Models\ng_user_relation', 'users_id', 'id');
    }

    public function ng_user_access_last()
    {
        return $this->hasOne('Models\ng_user_access', 'users_id', 'id')
            ->latest();
    }

    public function getMail()
    {
        return $this->email ? (filter_var($this->email, FILTER_VALIDATE_EMAIL) ? $this->email : 'support@iglobal.co.id') : 'support@iglobal.co.id';
    }

    public function getCleanName()
    {
        $name =  $this->name ? preg_replace('/[^A-Za-z\  ]/', '', substr($this->name, 0, 49)) : "No Name";
        return  str_replace("'", '', $name);
    }

    public function getAddress()
    {
        if (empty($this->address)) {
            return "Address Not Found";
        }
        return substr($this->address, 0, 99);
    }

    public function getCellphone()
    {
        return $this->phone;
    }

    public function is_admin()
    {
        $user_groups = $this->user_group()->get();
        if ($user_groups->count() > 0) {
            foreach ($user_groups as $user_group) {
                if ($user_group->groups->code == "adm") {
                    return true;
                }
            }
        }
        return false;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token, $this));
    }
}